<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 9:48 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Application\Booking;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager;
use Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface;
use Codeliner\CargoBackend\Model\Routing\RoutingServiceInterface;
use Interop\Container\ContainerInterface;

/**
 * Class BookingServiceFactory
 *
 * @package Codeliner\CargoBackend\Container\Booking
 */
final class BookingServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return BookingService
     */
    public function __invoke(ContainerInterface $container): BookingService
    {
        $config = $container->get('config');

        $locations = $config['locations']?? [];

        return new BookingService(
            $container->get(CargoRepositoryInterface::class),
            $container->get(TransactionManager::class),
            $container->get(RoutingServiceInterface::class),
            $locations
        );
    }
}
