<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:21
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Booking\Assembler;

use Codeliner\CargoBackend\Application\Booking\Dto\CargoRoutingDto;
use Codeliner\CargoBackend\Application\Booking\Dto\LegDto;
use Codeliner\CargoBackend\Model\Cargo\Cargo;

/**
 * Class CargoRoutingDtoAssembler
 *
 * @package Codeliner\CargoBackend\Application\Booking\Assembler
 * @author Alexander Miertsch <contact@prooph.de>
 */
class CargoRoutingDtoAssembler 
{
    /**
     * @param Cargo $aCargo
     * @return CargoRoutingDto
     */
    public function toDto(Cargo $aCargo): CargoRoutingDto
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
 