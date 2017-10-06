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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Main
 *
 * This middleware is the main entry point to the CargoUI.
 * It compiles riot.js tags and put them into a HTML5 layout together
 * with some js libs and bootstrap css.
 * If enabled it caches the compiled layout to respond fast on subsequent requests
 * and let the riot SPA handle the client logic.
 *
 * @package Codeliner\CargoUI
 * @author Alexander Miertsch <contact@prooph.de>
 */
final class Main
{
    /**
     * @var bool
     */
    private $cacheEnabled;

    /**
     * @var string
     */
    private $layout;

    /**
     * @var string
     */
    private $layoutCacheFile = 'data/cache/layout.phtml';

    /**
     * @var RiotCompiler
     */
    private $riotCompiler;

    /**
     * @param string $layout
     * @param bool $cacheEnabled
     * @param RiotCompiler $riotCompiler
     */
    public function __construct($layout, $cacheEnabled, RiotCompiler $riotCompiler)
    {
        $this->layout = (string)$layout;
        $this->cacheEnabled = (bool)$cacheEnabled;
        $this->riotCompiler = $riotCompiler;
    }

    /**
     * Render layout and write it to the response body
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null): ResponseInterface
    {
        $layout = $this->renderLayout();

        $response->getBody()->write($layout);

        return $response;
    }

    private function renderLayout(): string
    {
        if ($this->cacheEnabled && file_exists($this->layoutCacheFile)) {
            return file_get_contents($this->layoutCacheFile);
        }

        $layout = "";
        try {
            ob_start();
            $includeReturn = include $this->layout;
            $layout = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }
        if ($includeReturn === false && empty($layout)) {
            throw new \UnexpectedValueException(sprintf(
                'Unable to render layout "%s"; file include failed',
                $this->layout
            ));
        }

        if ($this->cacheEnabled) {
            file_put_contents($this->layoutCacheFile, $layout);
        }

        return $layout;
    }

    /**
     * @return string
     */
    private function compileRiot(): string
    {
        return $this->riotCompiler->compileToRiotStatements();
    }
}