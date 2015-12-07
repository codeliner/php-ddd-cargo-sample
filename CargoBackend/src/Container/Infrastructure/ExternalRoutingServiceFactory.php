<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 10:01 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Infrastructure;

use Codeliner\CargoBackend\Infrastructure\Routing\ExternalRoutingService;
use Codeliner\GraphTraversalBackend\GraphTraversalServiceInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ExternalRoutingServiceFactory
 *
 * @package Codeliner\CargoBackend\Container\Infrastructure
 */
final class ExternalRoutingServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return ExternalRoutingService
     */
    public function __invoke(ContainerInterface $container): ExternalRoutingService
    {
        return new ExternalRoutingService($container->get(GraphTraversalServiceInterface::class));
    }
}
