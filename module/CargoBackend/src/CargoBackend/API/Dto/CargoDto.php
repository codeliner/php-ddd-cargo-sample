<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:18
 */

namespace CargoBackend\API\Dto;
use Assert\Assertion;

/**
 * Class CargoDto
 *
 * @package CargoBackend\API\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoDto 
{
    /**
     * @var string
     */
    private $trackingId;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var RouteSpecificationDto
     */
    private $routeSpecification;

    /**
     * @var ItineraryDto
     */
    private $itinerary;

    /**
     * @param ItineraryDto $itinerary
     */
    public function setItinerary(ItineraryDto $itinerary)
    {
        $this->itinerary = $itinerary;
    }

    /**
     * @return ItineraryDto
     */
    public function getItinerary()
    {
        return $this->itinerary;
    }

    /**
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        \Assert\that($origin)->notEmpty()->string();

        $this->origin = $origin;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param RouteSpecificationDto $routeSpecification
     */
    public function setRouteSpecification(RouteSpecificationDto $routeSpecification)
    {
        $this->routeSpecification = $routeSpecification;
    }

    /**
     * @return RouteSpecificationDto
     */
    public function getRouteSpecification()
    {
        return $this->routeSpecification;
    }

    /**
     * @param string $trackingId
     */
    public function setTrackingId($trackingId)
    {
        Assertion::uuid($trackingId);

        $this->trackingId = $trackingId;
    }

    /**
     * @return string
     */
    public function getTrackingId()
    {
        return $this->trackingId;
    }
}
