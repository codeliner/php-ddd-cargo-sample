<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:48
 */

namespace Codeliner\CargoBackend\Infrastructure\Routing;

use Codeliner\CargoBackend\Model\Cargo\Itinerary;
use Codeliner\CargoBackend\Model\Cargo\Leg;
use Codeliner\CargoBackend\Model\Cargo\RouteSpecification;
use Codeliner\CargoBackend\Model\Routing\RoutingServiceInterface;
use Codeliner\GraphTraversalBackend\Dto\EdgeDto;
use Codeliner\GraphTraversalBackend\Dto\TransitPathDto;
use Codeliner\GraphTraversalBackend\GraphTraversalServiceInterface;

/**
 * Class ExternalRoutingService
 *
 * Our end of the routing service. This is basically a data model
 * translation layer between our domain model and the API put forward
 * by the routing team, which operates in a different context from us.
 *
 * @package CargoBackend\Infrastructure\Routing
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ExternalRoutingService implements RoutingServiceInterface
{
    /**
     * @var GraphTraversalServiceInterface
     */
    private $graphTraversalService;

    /**
     * @param GraphTraversalServiceInterface $aGraphTraversalService
     */
    public function __construct(GraphTraversalServiceInterface $aGraphTraversalService)
    {
        $this->graphTraversalService = $aGraphTraversalService;
    }

    /**
     * @param RouteSpecification $aRouteSpecification
     * @return Itinerary[] A list of itineraries that satisfy the specification. May be an empty list if no route is found.
     */
    public function fetchRoutesForSpecification(RouteSpecification $aRouteSpecification): array
    {
        $transitPaths = $this->graphTraversalService->findShortestPath(
            $aRouteSpecification->origin(),
            $aRouteSpecification->destination()
        );

        $itineraries = array();

        foreach ($transitPaths as $transitPath) {
            $itineraries[] = $this->toItinerary($transitPath);
        }

        return $itineraries;
    }

    /**
     * @param TransitPathDto $aTransitPath
     * @return Itinerary
     */
    private function toItinerary(TransitPathDto $aTransitPath): Itinerary
    {
        $legs = array();

        foreach ($aTransitPath->getEdges() as $edge) {
            $legs[] = $this->toLeg($edge);
        }

        return new Itinerary($legs);
    }

    /**
     * @param EdgeDto $anEdgeDto
     * @return Leg
     */
    private function toLeg(EdgeDto $anEdgeDto): Leg
    {
        return new Leg(
            $anEdgeDto->getFromUnLocode(),
            $anEdgeDto->getToUnLocode(),
            \DateTimeImmutable::createFromFormat(\DateTime::ATOM, $anEdgeDto->getFromDate()),
            \DateTimeImmutable::createFromFormat(\DateTime::ATOM, $anEdgeDto->getToDate())
        );
    }
}
