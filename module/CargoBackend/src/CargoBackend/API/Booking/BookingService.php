<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:55
 */

namespace CargoBackend\API\Booking;

use CargoBackend\API\Booking\Assembler\CargoRoutingDtoAssembler;
use CargoBackend\API\Booking\Assembler\RouteCandidateDtoAssembler;
use CargoBackend\API\Booking\Dto\CargoRoutingDto;
use CargoBackend\API\Booking\Dto\LocationDto;
use CargoBackend\API\Booking\Dto\RouteCandidateDto;
use CargoBackend\API\Exception\CargoNotFoundException;
use CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager;
use CargoBackend\Model\Cargo\Cargo;
use CargoBackend\Model\Cargo\CargoRepositoryInterface;
use CargoBackend\Model\Cargo\RouteSpecification;
use CargoBackend\Model\Cargo\TrackingId;
use CargoBackend\Model\Service\RoutingServiceInterface;

/**
 * Class BookingService
 *
 * @package CargoBackend\API\Booking
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingService implements BookingServiceInterface
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
     * @return string TrackingId
     */
    public function bookNewCargo($anOrigin, $aDestination)
    {
        $trackingId = $this->cargoRepository->getNextTrackingId();

        $routeSpecification = new RouteSpecification($anOrigin, $aDestination);

        $cargo = new Cargo($trackingId, $routeSpecification);

        $this->transactionManager->beginTransaction();

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
     * @throws \CargoBackend\API\Exception\CargoNotFoundException
     * @return CargoRoutingDto
     */
    public function loadCargoForRouting($aTrackingId)
    {
        $cargo = $this->cargoRepository->get(TrackingId::fromString($aTrackingId));

        if (! $cargo) {
            throw new CargoNotFoundException(
                sprintf(
                    'Cargo with TrackingId -%s- can not be found.',
                    $aTrackingId
                )
            );
        }

        $cargoRoutingDtoAssembler = new CargoRoutingDtoAssembler();

        return $cargoRoutingDtoAssembler->toDto($cargo);
    }

    /**
     * @param string $aTrackingId
     * @throws \CargoBackend\API\Exception\CargoNotFoundException
     * @return RouteCandidateDto[]
     */
    public function requestPossibleRoutesForCargo($aTrackingId)
    {
        $cargo = $this->cargoRepository->get(TrackingId::fromString($aTrackingId));

        if (! $cargo) {
            throw new CargoNotFoundException(
                sprintf(
                    'Cargo with TrackingId -%s- could not be found',
                    $aTrackingId
                )
            );
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
     * @throws \CargoBackend\API\Exception\CargoNotFoundException
     * @throws \Exception
     * @return void
     */
    public function assignCargoToRoute($aTrackingId, RouteCandidateDto $aRoute)
    {
        $cargo = $this->cargoRepository->get(TrackingId::fromString($aTrackingId));

        if (! $cargo) {
            throw new CargoNotFoundException(
                sprintf(
                    'Cargo with TrackingId -%s- could not be found',
                    $aTrackingId
                )
            );
        }

        $routeCandidateAssembler = new RouteCandidateDtoAssembler();

        $itinerary = $routeCandidateAssembler->toItinerary($aRoute);

        $this->transactionManager->beginTransaction();

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
    public function listShippingLocations()
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
    public function listAllCargos()
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
 