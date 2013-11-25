<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Service\Factory;

use Application\Service\BookingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * ServiceFactory of BookingService
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $bookingService = new BookingService();
        $bookingService->setCargoRepository($serviceLocator->get('cargo_repository'));
        $bookingService->setVoyageRepository($serviceLocator->get('voyage_repository'));
        $bookingService->setOverbookingPolicy($serviceLocator->get('overbooking_policy'));
        return $bookingService;
    }
}
