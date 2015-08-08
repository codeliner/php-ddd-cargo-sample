<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/8/15 - 12:37 AM
 */
namespace Codeliner\CargoUI;

/**
 * Class RiotCompiler
 *
 * This is a very basic compiler for riot.js tag files.
 * It splits content of a <riot-tag-name>.html file into html and js and compiles
 * the parts into a riot.tag() statement.
 *
 * @package Codeliner\CargoUI
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RiotCompiler 
{
    private $riotTagsRootDir = 'CargoUI/view/riot';

    private $search = ['"', "\n"];

    private $replace = ['\"', ""];

    public function compileToRiotStatements()
    {
        $riotRootDir = new \DirectoryIterator($this->riotTagsRootDir);

        return $this->compileAll($riotRootDir);
    }

    private function compileAll(\DirectoryIterator $iterator)
    {
        $jsContent = "";

        /** @var $info \DirectoryIterator */
        foreach ($iterator as $info) {
            if ($info->isFile()) {
                $jsContent.= $this->compileFile($info);
            } elseif (!$info->isDot()) {
                $jsContent.= $this->compileAll(new \DirectoryIterator($iterator->getPath() . DIRECTORY_SEPARATOR . $info->getBasename()));
            }
        }

        return $jsContent;
    }
    
    private function compileFile(\DirectoryIterator $file)
    {
        $tag = file_get_contents($file->getPathname());
        $tagName = $file->getBasename('.html');
        $jsFunc = $this->extractJsFunction($tag, $tagName);
        $tagHtml = $this->removeJsFromTag($tag, $tagName);

        return 'riot.tag("'.$tagName.'", "' . str_replace($this->search, $this->replace, $tagHtml) . '", '.$jsFunc.');';
    }

    private function extractJsFunction($tag, $tagName)
    {
        preg_match('/<script .*type="text\/javascript"[^>]*>[\s]*(?<func>function.+\});?[\s]*<\/script>/is', $tag, $matches);

        if (! $matches['func']) {
            throw new \RuntimeException("Riot tag javascript function could not be found for tag name: " . $tagName);
        }

        return $matches['func'];
    }

    private function removeJsFromTag($tag, $tagName)
    {
        $tag = preg_replace('/<script .*type="text\/javascript"[^>]*>.*<\/script>/is', "", $tag);

        if (! $tag) {
            throw new \RuntimeException("Riot tag template compilation failed for tag: " . $tagName . " with error code: " . preg_last_error());
        }

        return $tag;
    }
} 