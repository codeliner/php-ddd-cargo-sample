<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Model\Cargo;

/**
 * A Cargo. This is the central class in the domain model.
 *
 * A cargo is identified by a unique tracking id, and it always has an origin
 * and a route specification. The life cycle of a cargo begins with the booking procedure,
 * when the tracking id is assigned. During a (short) period of time, between booking
 * and initial routing, the cargo has no itinerary.
 *
 * The booking clerk requests a list of possible routes, matching the route specification,
 * and assigns the cargo to one route. The route to which a cargo is assigned is described
 * by an itinerary.
 *
 * A cargo can be re-routed during transport, on demand of the customer, in which case
 * a new route is specified for the cargo and a new route is requested. The old itinerary,
 * being a value object, is discarded and a new one is attached.
 * 
 * @author Alexander Miertsch <contact@prooph.de>
 */
class Cargo
{
    /**
     * Unique Identifier
     * 
     * @var TrackingId
     */
    private $trackingId;
    
    /**
     * @var string
     */
    private $origin;
    
    /**
     *
     * @var RouteSpecification 
     */
    private $routeSpecification;

    /**
     * @var Itinerary
     */
    private $itinerary;

    /**
     * Construct
     *
     * @param TrackingId $aTrackingId
     * @param RouteSpecification $aRouteSpecification
     */
    public function __construct(TrackingId $aTrackingId, RouteSpecification $aRouteSpecification)
    {
        $this->trackingId = $aTrackingId;

        //Construct is only called when the Cargo is initially created.
        //Doctrine do not call __construct when it recreates a persisted entity.
        //Therefor we can assign the origin here.
        //It will be always the same for that specific Cargo even if the RouteSpecification changes.
        $this->origin     = $aRouteSpecification->origin();

        $this->routeSpecification = $aRouteSpecification;
    }
    
    /**
     * @return TrackingId Unique Identifier of this Cargo
     */
    public function trackingId(): TrackingId
    {
        return $this->trackingId;
    }

    /**
     * @return string Origin of this Cargo
     */
    public function origin(): string
    {
        return $this->origin;
    }

    /**
     * @return RouteSpecification
     */
    public function routeSpecification(): RouteSpecification
    {
        return $this->routeSpecification;
    }

    /**
     * Specifies a new route for this cargo.
     *
     * @param RouteSpecification $aRouteSpecification
     */
    public function specifyNewRoute(RouteSpecification $aRouteSpecification): void
    {
        $this->routeSpecification = $aRouteSpecification;
    }

    /**
     * @return Itinerary Never null
     */
    public function itinerary(): Itinerary
    {
        if (is_null($this->itinerary)) {
            return new Itinerary(array());
        } else {
            return $this->itinerary;
        }
    }

    /**
     * Attach a new itinerary to this cargo.
     *
     * @param Itinerary $anItinerary
     */
    public function assignToRoute(Itinerary $anItinerary): void
    {
        $this->itinerary = $anItinerary;
    }

    /**
     * @param Cargo $other
     * @return bool
     */
    public function sameIdentityAs(Cargo $other): bool
    {
        return $this->trackingId()->sameValueAs($other->trackingId());
    }
}
