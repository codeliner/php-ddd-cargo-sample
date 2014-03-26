<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 21:35
 */

namespace CargoBackend\API;

use CargoBackend\API\Dto\CargoDto;
use CargoBackend\API\Dto\ItineraryDto;
use CargoBackend\API\Dto\LegDto;
use CargoBackend\API\Dto\RouteSpecificationDto;
use CargoBackend\API\Dto\TrackingIdDto;
use CargoBackend\API\Dto\TrackingIdListDto;
use CargoBackend\API\Exception\CargoNotFoundException;
use CargoBackend\Model\Cargo\CargoRepositoryInterface;
use CargoBackend\Model\Cargo\TrackingId;
use Rhumsaa\Uuid\Uuid;

/**
 * Class CargoService
 *
 * @package CargoBackend\API
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoService 
{
    /**
     * @var CargoRepositoryInterface
     */
    private $cargoRepository;

    /**
     * @param CargoRepositoryInterface $aCargoRepository
     */
    public function __construct(CargoRepositoryInterface $aCargoRepository)
    {
        $this->cargoRepository = $aCargoRepository;
    }

    /**
     * @return TrackingIdListDto
     */
    public function listAllCargoTrackingIds()
    {
        $cargoCollection = $this->cargoRepository->getAll();

        $trackingIds = array();

        foreach ($cargoCollection as $cargo) {
            $trackingIds[] = $cargo->trackingId()->toString();
        }

        $trackingIdList = new TrackingIdListDto();
        $trackingIdList->setTrackingIds($trackingIds);

        return $trackingIdList;
    }

    /**
     * @param TrackingIdDto $aTrackingIdDto
     * @return CargoDto
     * @throws Exception\CargoNotFoundException If Cargo can not be found
     */
    public function getCargoDataByTrackingId(TrackingIdDto $aTrackingIdDto)
    {
        $trackingId = new TrackingId(Uuid::fromString($aTrackingIdDto->getTrackingId()));

        $cargo = $this->cargoRepository->get($trackingId);

        if (! $cargo) {
            throw new CargoNotFoundException(
                sprintf(
                    'Cargo with trackingId -%s- can not be found',
                    $trackingId->toString()
                )
            );
        }

        $cargoDto = new CargoDto();

        $cargoDto->setTrackingId($cargo->trackingId()->toString());
        $cargoDto->setOrigin($cargo->origin());

        $routeSpecificationDto = new RouteSpecificationDto();

        $routeSpecificationDto->setOrigin($cargo->routeSpecification()->origin());
        $routeSpecificationDto->setDestination($cargo->routeSpecification()->destination());

        $cargoDto->setRouteSpecification($routeSpecificationDto);

        $itineraryDto = new ItineraryDto();

        foreach ($cargo->itinerary()->legs() as $leg) {
            $legDto = new LegDto();

            $legDto->setLoadLocation($leg->loadLocation());
            $legDto->setUnloadLocation($leg->unloadLocation());
            $legDto->setLoadTime($leg->loadTime()->format(\DateTime::ISO8601));
            $legDto->setUnloadTime($leg->unloadTime()->format(\DateTime::ISO8601));

            $itineraryDto->addLeg($legDto);
        }

        $cargoDto->setItinerary($itineraryDto);

        return $cargoDto;
    }
}
 