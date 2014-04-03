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

namespace CargoBackend\Infrastructure\Routing\Service;

use CargoBackend\Infrastructure\Routing\ExternalRoutingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ExternalRoutingServiceFactory
 *
 * @package CargoBackend\Infrastructure\Routing\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ExternalRoutingServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ExternalRoutingService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ExternalRoutingService($serviceLocator->get('graph_traversal_service'));
    }
}
 