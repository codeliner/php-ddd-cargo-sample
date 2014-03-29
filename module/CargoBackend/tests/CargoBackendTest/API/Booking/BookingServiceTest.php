<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:59
 */

namespace CargoBackendTest\Domain\API\Booking;

use CargoBackend\API\Booking\BookingService;
use CargoBackend\API\Booking\BookingServiceInterface;
use CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager;
use CargoBackend\Infrastructure\Routing\ExternalRoutingService;
use CargoBackend\Model\Cargo\CargoRepositoryInterface;
use CargoBackend\Model\Cargo\TrackingId;
use CargoBackendTest\Mock\GraphTraversalServiceMock;
use CargoBackendTest\TestCase;

/**
 * Class BookingServiceTest
 *
 * @package CargoBackendTest\Domain\API\Booking
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingServiceTest extends TestCase
{
    /**
     * @var CargoRepositoryInterface
     */
    private $cargoRepository;

    /**
     * @var BookingServiceInterface
     */
    private $bookingService;

    protected function setUp()
    {
        $this->createEntitySchema('CargoBackend\Model\Cargo\Cargo');
        $this->createEntitySchema('CargoBackend\Model\Cargo\Itinerary');
        $this->createEntitySchema('CargoBackend\Model\Cargo\RouteSpecification');

        $this->cargoRepository = $this->getTestEntityManager()->getRepository('CargoBackend\Model\Cargo\Cargo');

        $this->bookingService = new BookingService(
            $this->cargoRepository,
            new TransactionManager($this->getTestEntityManager()),
            new ExternalRoutingService(new GraphTraversalServiceMock()),
            array('DEHAM' => 'Hamburg', 'USNYC' => 'New York')
        );
    }

    /**
     * @test
     */
    public function it_creates_a_new_cargo_and_assign_route_specification()
    {
        $trackingId = $this->bookingService->bookNewCargo('USNYC', 'DEHAM');

        $this->assertNotEmpty($trackingId);

        $cargo = $this->cargoRepository->get(TrackingId::fromString($trackingId));

        $this->assertNotNull($cargo);

        $this->assertEquals('USNYC', $cargo->origin());
        $this->assertEquals('USNYC', $cargo->routeSpecification()->origin());
        $this->assertEquals('DEHAM', $cargo->routeSpecification()->destination());
    }

    /**
     * @test
     */
    public function it_loads_cargo_for_routing()
    {
        $trackingId = $this->bookingService->bookNewCargo('USNYC', 'DEHAM');

        $cargoRoutingDto = $this->bookingService->loadCargoForRouting($trackingId);

        $this->assertInstanceOf('CargoBackend\API\Booking\Dto\CargoRoutingDto', $cargoRoutingDto);

        $this->assertEquals('USNYC', $cargoRoutingDto->getOrigin());
        $this->assertEquals('DEHAM', $cargoRoutingDto->getFinalDestination());
        $this->assertEquals($trackingId, $cargoRoutingDto->getTrackingId());
    }

    /**
     * @test
     */
    public function it_provides_possible_routes_for_cargo()
    {
        $trackingId = $this->bookingService->bookNewCargo('USNYC', 'DEHAM');

        $routeCandidates = $this->bookingService->requestPossibleRoutesForCargo($trackingId);

        $this->assertEquals(1, count($routeCandidates));

        $routeCandidate = $routeCandidates[0];

        $this->assertInstanceOf('CargoBackend\API\Booking\Dto\RouteCandidateDto', $routeCandidate);

        $legs = $routeCandidate->getLegs();

        $this->assertEquals(1, count($legs));

        $this->assertInstanceOf('CargoBackend\API\Booking\Dto\LegDto', $legs[0]);
    }

    /**
     * @test
     */
    public function it_assigns_cargo_to_route()
    {
        $trackingId = $this->bookingService->bookNewCargo('USNYC', 'DEHAM');

        $routeCandidates = $this->bookingService->requestPossibleRoutesForCargo($trackingId);

        $this->bookingService->assignCargoToRoute($trackingId, $routeCandidates[0]);

        $cargo = $this->cargoRepository->get(TrackingId::fromString($trackingId));

        $legs = $cargo->itinerary()->legs();

        $this->assertEquals(1, count($legs));

        $this->assertEquals('USNYC', $legs[0]->loadLocation());
        $this->assertEquals('DEHAM', $legs[0]->unloadLocation());
    }

    /**
     * @test
     */
    public function it_lists_available_shipping_locations()
    {
        $locations = $this->bookingService->listShippingLocations();

        $this->assertEquals(2, count($locations));

        $this->assertInstanceOf('CargoBackend\API\Booking\Dto\LocationDto', $locations[0]);

        $this->assertEquals('DEHAM', $locations[0]->getUnLocode());
        $this->assertEquals('Hamburg', $locations[0]->getName());
    }

    /**
     * @test
     */
    public function it_lists_all_stored_cargos()
    {
        $trackingIdOne = $this->bookingService->bookNewCargo('USNYC', 'DEHAM');

        $trackingIdTwo = $this->bookingService->bookNewCargo('NLRTM', 'USNYC');


        $cargoRoutingDtos = $this->bookingService->listAllCargos();

        $this->assertEquals(2, count($cargoRoutingDtos));

        $generatedTrackingIds = [$trackingIdOne, $trackingIdTwo];


        foreach ($cargoRoutingDtos as $cargoRoutingDto) {
            $this->assertTrue(in_array($cargoRoutingDto->getTrackingId(), $generatedTrackingIds));
        }
    }
}
 