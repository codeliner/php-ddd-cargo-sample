<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
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
 * @author Alexander Miertsch <contact@prooph.de>
 */
final class RiotCompiler 
{
    private $riotTagsRootDir = 'CargoUI/view/riot';

    public function compileToRiotStatements(): string
    {
        $riotRootDir = new \DirectoryIterator($this->riotTagsRootDir);

        return $this->compileAll($riotRootDir);
    }

    private function compileAll(\DirectoryIterator $iterator): string
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
    
    private function compileFile(\DirectoryIterator $file): string
    {
        $tag = file_get_contents($file->getPathname());
        $tagName = $file->getBasename('.html');
        $jsFunc = $this->extractJsFunction($tag, $tagName);
        $tagHtml = $this->removeJsFromTag($tag, $tagName);

        $tagHtml = str_replace('"', '\"', $tagHtml);
        $tagHtml = preg_replace("/\r|\n/", "", $tagHtml);

        return 'riot.tag("'.$tagName.'", "' . $tagHtml . '", '.$jsFunc.');';
    }

    private function extractJsFunction(string $tag, string $tagName): string
    {
        preg_match('/<script .*type="text\/javascript"[^>]*>[\s]*(?<func>function.+\});?[\s]*<\/script>/is', $tag, $matches);

        if (! $matches['func']) {
            throw new \RuntimeException("Riot tag javascript function could not be found for tag name: " . $tagName);
        }

        return $matches['func'];
    }

    private function removeJsFromTag(string $tag, string $tagName): string
    {
        $tag = preg_replace('/<script .*type="text\/javascript"[^>]*>.*<\/script>/is', "", $tag);

        if (! $tag) {
            throw new \RuntimeException("Riot tag template compilation failed for tag: " . $tagName . " with error code: " . preg_last_error());
        }

        return $tag;
    }
} 