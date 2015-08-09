<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
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
use Codeliner\CargoBackend\Model\Service\RoutingServiceInterface;
use Codeliner\GraphTraversalService\Dto\EdgeDto;
use Codeliner\GraphTraversalService\Dto\TransitPathDto;
use Codeliner\GraphTraversalService\GraphTraversalServiceInterface;

/**
 * Class ExternalRoutingService
 *
 * Our end of the routing service. This is basically a data model
 * translation layer between our domain model and the API put forward
 * by the routing team, which operates in a different context from us.
 *
 * @package Codeliner\CargoBackend\Infrastructure\Routing
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
    public function fetchRoutesForSpecification(RouteSpecification $aRouteSpecification)
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
    private function toItinerary(TransitPathDto $aTransitPath)
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
    private function toLeg(EdgeDto $anEdgeDto)
    {
        return new Leg(
            $anEdgeDto->getFromUnLocode(),
            $anEdgeDto->getToUnLocode(),
            new \DateTime($anEdgeDto->getFromDate()),
            new \DateTime($anEdgeDto->getToDate())
        );
    }
}
 