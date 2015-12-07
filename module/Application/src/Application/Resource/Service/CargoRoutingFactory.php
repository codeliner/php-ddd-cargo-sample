<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 30.03.14 - 00:15
 */

namespace Application\Resource\Service;

use Application\Resource\CargoRouting;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CargoRoutingFactory
 *
 * @package Application\Resource\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRoutingFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CargoRouting
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CargoRouting($serviceLocator->get('cargo_booking_service'), $serviceLocator->get('cargo_form'));
    }
}
 