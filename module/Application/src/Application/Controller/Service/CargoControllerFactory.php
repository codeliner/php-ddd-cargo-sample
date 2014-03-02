<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.03.14 - 18:26
 */

namespace Application\Controller\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CargoControllerFactory
 *
 * @package Application\Controller\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Application\Controller\CargoController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceManager = $serviceLocator->getServiceLocator();

        $cargoRepository = $serviceManager->get('cargo_repository');

        $cargoController = new \Application\Controller\CargoController();
        $cargoController->setCargoRepository($cargoRepository);
        $cargoController->setCargoForm($serviceManager->get('cargo_form'));
        $cargoController->setRoutingService($serviceManager->get('routing_service'));
        $cargoController->setLocations($serviceManager->get('config')['locations']);
        return $cargoController;
    }
}