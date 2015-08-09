<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:43
 */

namespace Codeliner\CargoBackend\Model\Service;

use Codeliner\CargoBackend\Model\Cargo\Itinerary;
use Codeliner\CargoBackend\Model\Cargo\RouteSpecification;

/**
 * Interface RoutingServiceInterface
 *
 * @package Codeliner\CargoBackend\Model\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface RoutingServiceInterface 
{
    /**
     * @param RouteSpecification $aRouteSpecification
     * @return Itinerary[] A list of itineraries that satisfy the specification. May be an empty list if no route is found.
     */
    public function fetchRoutesForSpecification(RouteSpecification $aRouteSpecification);
}
 