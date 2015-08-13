<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/9/15 - 10:26 PM
 */
namespace Codeliner\CargoBackend\API\Factory;

use Interop\Container\ContainerInterface;
use Zend\Expressive\AppFactory;

/**
 * Class HttpRequestDispatcherFactory
 *
 * @package Codeliner\CargoBackend\API\Factory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class HttpRequestDispatcherFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get('cargo.backend.router');

        $app = AppFactory::create($container, $router);

        $app->pipe("/", [$app, 'routeMiddleware']);

        return $app;
    }
}