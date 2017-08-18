<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:59
 */

namespace CodelinerTest\CargoBackend\Domain\API\Booking;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Application\Booking\Dto\CargoRoutingDto;
use Codeliner\CargoBackend\Application\Booking\Dto\LegDto;
use Codeliner\CargoBackend\Application\Booking\Dto\LocationDto;
use Codeliner\CargoBackend\Application\Booking\Dto\RouteCandidateDto;
use Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\DoctrineORMTransactionManager;
use Codeliner\CargoBackend\Infrastructure\Routing\ExternalRoutingService;
use Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface;
use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use CodelinerTest\CargoBackend\Mock\GraphTraversalServiceMock;
use CodelinerTest\CargoBackend\TestCase;

/**
 * Class BookingServiceTest
 *
 * @package CodelinerTest\CargoBackend\Domain\API\Booking
 * @author Alexander Miertsch <contact@prooph.de>
 */
class BookingServiceTest extends TestCase
{
    /**
     * @var CargoRepositoryInterface
     */
    private $cargoRepository;

    /**
     * @var BookingService
     */
    private $bookingService;

    protected function setUp()
    {
        $this->createEntitySchema('Codeliner\CargoBackend\Model\Cargo\Cargo');

        $this->cargoRepository = $this->getTestEntityManager()->getRepository('Codeliner\CargoBackend\Model\Cargo\Cargo');

        $this->bookingService = new BookingService(
            $this->cargoRepository,
            new DoctrineORMTransactionManager($this->getTestEntityManager()),
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

        $this->assertInstanceOf(CargoRoutingDto::class, $cargoRoutingDto);

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

        $this->assertInstanceOf(RouteCandidateDto::class, $routeCandidate);

        $legs = $routeCandidate->getLegs();

        $this->assertEquals(1, count($legs));

        $this->assertInstanceOf(LegDto::class, $legs[0]);
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

        $this->assertInstanceOf(LocationDto::class, $locations[0]);

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
 