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

namespace Codeliner\CargoBackend\API\Factory;

use Codeliner\CargoBackend\API\Booking\BookingService;
use Interop\Container\ContainerInterface;

/**
 * Class BookingServiceFactory
 *
 * @package Codeliner\CargoBackend\API\Booking\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingServiceFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return BookingService
     */
    public function __invoke(ContainerInterface $container)
    {
        $configuration = $container->get('configuration');

        return new BookingService(
            $container->get('cargo.backend.cargo_repository'),
            $container->get('cargo.backend.transaction_manager'),
            $container->get('cargo.backend.cargo_routing_service'),
            $configuration['locations']
        );
    }
}
 