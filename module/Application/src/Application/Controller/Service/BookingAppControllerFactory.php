<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 30.03.14 - 23:54
 */

namespace Application\Controller\Service;

use Application\Controller\BookingAppController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BookingAppControllerFactory
 *
 * @package Application\Controller\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingAppControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return BookingAppController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        return new BookingAppController($services->get('cargo_booking_service'), $services->get('cargo_form'));
    }
}
 