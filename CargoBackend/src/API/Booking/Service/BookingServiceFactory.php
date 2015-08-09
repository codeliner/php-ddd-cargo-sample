<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 30.03.14 - 00:18
 */

namespace Codeliner\CargoBackend\API\Booking\Service;

use Codeliner\CargoBackend\API\Booking\BookingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BookingServiceFactory
 *
 * @package Codeliner\CargoBackend\API\Booking\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return BookingService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $configuration = $serviceLocator->get('configuration');

        return new BookingService(
            $serviceLocator->get('cargo_repository'),
            $serviceLocator->get('cargo_transaction_manager'),
            $serviceLocator->get('cargo_routing_service'),
            $configuration['locations']
        );
    }
}
 