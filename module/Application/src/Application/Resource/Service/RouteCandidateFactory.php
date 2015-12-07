<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 03.04.14 - 22:16
 */

namespace Application\Resource\Service;

use Application\Resource\RouteCandidate;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RouteCandidateFactory
 *
 * @package Application\Resource\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteCandidateFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return RouteCandidate
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RouteCandidate($serviceLocator->get('cargo_booking_service'));
    }
}
 