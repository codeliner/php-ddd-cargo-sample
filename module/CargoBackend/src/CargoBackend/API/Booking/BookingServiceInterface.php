<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 16:52
 */

namespace CargoBackend\API\Booking;

use CargoBackend\API\Booking\Dto\CargoRoutingDto;
use CargoBackend\API\Booking\Dto\LocationDto;
use CargoBackend\API\Booking\Dto\RouteCandidateDto;

/**
 * Interface BookingServiceInterface
 *
 * This API\Service shields the domain layer - model, services, repositories -
 * from concerns about such things as the user interface and remoting.
 *
 * @package CargoBackend\API\Booking
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface BookingServiceInterface 
{
    /**
     * Registers a new cargo in the tracking system, not yet routed.
     *
     * @param string $anOrigin
     * @param string $aDestination
     * @return string TrackingId
     */
    public function bookNewCargo($anOrigin, $aDestination);

    /**
     * @param string $aTrackingId
     * @return CargoRoutingDto
     */
    public function loadCargoForRouting($aTrackingId);

    /**
     * Requests a list of possible routes for this cargo.
     *
     * @param string $aTrackingId
     * @return RouteCandidateDto[]
     */
    public function requestPossibleRoutesForCargo($aTrackingId);

    /**
     * @param string            $aTrackingId
     * @param RouteCandidateDto $aRoute
     * @return void
     */
    public function assignCargoToRoute($aTrackingId, RouteCandidateDto $aRoute);

    /**
     * @return LocationDto[]
     */
    public function listShippingLocations();

    /**
     * @return CargoRoutingDto[]
     */
    public function listAllCargos();
}
 