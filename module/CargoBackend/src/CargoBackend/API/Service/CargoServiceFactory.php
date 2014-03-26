<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 21:45
 */

namespace CargoBackend\API\Service;

use CargoBackend\API\CargoService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CargoServiceFactory
 *
 * @package CargoBackend\API\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CargoService($serviceLocator->get('cargo_repository'));
    }
}
 