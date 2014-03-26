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

use CargoBackend\API\Dto\TrackingIdListDto;
use CargoBackend\Model\Cargo\CargoRepositoryInterface;

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
}
 