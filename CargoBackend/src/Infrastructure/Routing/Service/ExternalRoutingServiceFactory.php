<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 30.03.14 - 13:23
 */

namespace Codeliner\CargoBackend\Infrastructure\Routing\Service;

use Codeliner\CargoBackend\Infrastructure\Routing\ExternalRoutingService;
use Interop\Container\ContainerInterface;

/**
 * Class ExternalRoutingServiceFactory
 *
 * @package Codeliner\CargoBackend\Infrastructure\Routing\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ExternalRoutingServiceFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return ExternalRoutingService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ExternalRoutingService($container->get('graph_traversal_service'));
    }
}
 