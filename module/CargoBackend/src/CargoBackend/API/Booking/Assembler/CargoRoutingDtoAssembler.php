<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:21
 */

namespace CargoBackend\API\Booking\Assembler;
use CargoBackend\API\Booking\Dto\CargoRoutingDto;
use CargoBackend\API\Booking\Dto\LegDto;
use CargoBackend\Model\Cargo\Cargo;

/**
 * Class CargoRoutingDtoAssembler
 *
 * @package CargoBackend\API\Booking\Assembler
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRoutingDtoAssembler 
{
    /**
     * @param Cargo $aCargo
     * @return CargoRoutingDto
     */
    public function toDto(Cargo $aCargo)
    {
        $cargoRoutingDto = new CargoRoutingDto();

        $cargoRoutingDto->setTrackingId($aCargo->trackingId()->toString());
        $cargoRoutingDto->setOrigin($aCargo->origin());
        $cargoRoutingDto->setFinalDestination($aCargo->routeSpecification()->destination());

        foreach ($aCargo->itinerary()->legs() as $leg) {
            $legDto = new LegDto();

            $legDto->setLoadLocation($leg->loadLocation());
            $legDto->setUnloadLocation($leg->unloadLocation());
            $legDto->setLoadTime($leg->loadTime()->format(\DateTime::ISO8601));
            $legDto->setUnloadTime($leg->unloadTime()->format(\DateTime::ISO8601));

            $cargoRoutingDto->addLeg($legDto);
        }

        return $cargoRoutingDto;
    }
}
 