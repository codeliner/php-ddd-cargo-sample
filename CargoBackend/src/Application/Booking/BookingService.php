<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:55
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Booking;

use Codeliner\CargoBackend\Application\Booking\Assembler\CargoRoutingDtoAssembler;
use Codeliner\CargoBackend\Application\Booking\Assembler\RouteCandidateDtoAssembler;
use Codeliner\CargoBackend\Application\Booking\Dto\CargoRoutingDto;
use Codeliner\CargoBackend\Application\Booking\Dto\LocationDto;
use Codeliner\CargoBackend\Application\Booking\Dto\RouteCandidateDto;
use Codeliner\CargoBackend\Application\Exception\CargoNotFoundException;
use Codeliner\CargoBackend\Application\TransactionManager;
use Codeliner\CargoBackend\Model\Cargo\Cargo;
use Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface;
use Codeliner\CargoBackend\Model\Cargo\RouteSpecification;
use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use Codeliner\CargoBackend\Model\Routing\RoutingServiceInterface;

/**
 * Class BookingService
 *
 * @package Codeliner\CargoBackend\Application\Booking
 * @author Alexander Miertsch <contact@prooph.de>
 */
class BookingService
{
    /**
     * @var CargoRepositoryInterface
     */
    private $cargoRepository;

    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * @var RoutingServiceInterface
     */
    private $routingService;

    /**
     * @var array List of locations
     */
    private $locations;

    /**
     * @param CargoRepositoryInterface $aCargoRepository
     * @param TransactionManager $aTransactionManager
     * @param RoutingServiceInterface $aRoutingService
     * @param array $locations
     */
    public function __construct(
        CargoRepositoryInterface $aCargoRepository,
        TransactionManager $aTransactionManager,
        RoutingServiceInterface $aRoutingService,
        array $locations
    ) {
        $this->cargoRepository    = $aCargoRepository;
        $this->transactionManager = $aTransactionManager;
        $this->routingService     = $aRoutingService;
        $this->locations          = $locations;
    }

    /**
     * @param string $anOrigin
     * @param string $aDestination
     * @throws \Exception If booking fails
     * @return string
     */
    public function bookNewCargo(string $anOrigin, string $aDestination): string
    {
        $trackingId = $this->cargoRepository->getNextTrackingId();

        $routeSpecification = new RouteSpecification($anOrigin, $aDestination);

        $cargo = new Cargo($trackingId, $routeSpecification);

        $this->transactionManager->begin();

        try {
            $this->cargoRepository->store($cargo);

            $this->transactionManager->commit();

            return $trackingId->toString();
        } catch (\Exception $ex) {
            $this->transactionManager->rollback();

            throw $ex;
        }
    }

    /**
     * @param string $aTrackingId
     * @throws \Codeliner\CargoBackend\Application\Exception\CargoNotFoundException
     * @return CargoRoutingDto
     */
    public function loadCargoForRouting(string $aTrackingId): CargoRoutingDto
    {
        $aTrackingId = TrackingId::fromString($aTrackingId);

        $cargo = $this->cargoRepository->get($aTrackingId);

        if (! $cargo) {
            throw CargoNotFoundException::forTrackingId($aTrackingId);
        }

        $cargoRoutingDtoAssembler = new CargoRoutingDtoAssembler();

        return $cargoRoutingDtoAssembler->toDto($cargo);
    }

    /**
     * @param string $aTrackingId
     * @throws CargoNotFoundException
     * @return RouteCandidateDto[]
     */
    public function requestPossibleRoutesForCargo(string $aTrackingId): array
    {
        $aTrackingId = TrackingId::fromString($aTrackingId);

        $cargo = $this->cargoRepository->get($aTrackingId);

        if (! $cargo) {
            throw CargoNotFoundException::forTrackingId($aTrackingId);
        }

        $itineraries = $this->routingService->fetchRoutesForSpecification($cargo->routeSpecification());

        $routeCandidates = array();
        $routeCandidateAssembler = new RouteCandidateDtoAssembler();

        foreach ($itineraries as $itinerary) {
            $routeCandidates[] = $routeCandidateAssembler->toDto($itinerary);
        }

        return $routeCandidates;
    }

    /**
     * @param string $aTrackingId
     * @param RouteCandidateDto $aRoute
     * @throws CargoNotFoundException
     * @throws \Exception
     * @return void
     */
    public function assignCargoToRoute(string $aTrackingId, RouteCandidateDto $aRoute)
    {
        $aTrackingId = TrackingId::fromString($aTrackingId);
        $cargo = $this->cargoRepository->get($aTrackingId);

        if (! $cargo) {
            throw CargoNotFoundException::forTrackingId($aTrackingId);
        }

        $routeCandidateAssembler = new RouteCandidateDtoAssembler();

        $itinerary = $routeCandidateAssembler->toItinerary($aRoute);

        $this->transactionManager->begin();

        try {

            $cargo->assignToRoute($itinerary);

            $this->cargoRepository->store($cargo);

            $this->transactionManager->commit();

        } catch (\Exception $ex) {

            $this->transactionManager->rollback();

            throw $ex;
        }
    }

    /**
     * @return LocationDto[]
     */
    public function listShippingLocations(): array
    {
        $locationDtos = array();

        foreach ($this->locations as $unLocode => $name) {
            $locationDto = new LocationDto();
            $locationDto->setUnLocode($unLocode);
            $locationDto->setName($name);

            $locationDtos[] = $locationDto;
        }

        return $locationDtos;
    }

    /**
     * @return CargoRoutingDto[]
     */
    public function listAllCargos(): array
    {
        $cargos = $this->cargoRepository->getAll();

        $cargoRoutingDtos = array();

        $cargoRoutingDtoAssembler = new CargoRoutingDtoAssembler();

        foreach ($cargos as $cargo) {
            $cargoRoutingDtos[] = $cargoRoutingDtoAssembler->toDto($cargo);
        }

        return $cargoRoutingDtos;
    }
}
