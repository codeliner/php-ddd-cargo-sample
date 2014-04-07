<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 21:06
 */

namespace CargoBackend\API\Booking\Assembler;

use CargoBackend\API\Booking\Dto\LegDto;
use CargoBackend\API\Booking\Dto\RouteCandidateDto;
use CargoBackend\Model\Cargo\Itinerary;
use CargoBackend\Model\Cargo\Leg;

/**
 * Class RouteCandidateDtoAssembler
 *
 * @package CargoBackend\API\Booking\Assembler
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteCandidateDtoAssembler 
{
    /**
     * @param Itinerary $anItinerary
     * @return RouteCandidateDto
     */
    public function toDto(Itinerary $anItinerary)
    {
        $legs = array();

        foreach ($anItinerary->legs() as $leg) {
            $legDto = new LegDto();

            $legDto->setLoadLocation($leg->loadLocation());
            $legDto->setUnloadLocation($leg->unloadLocation());
            $legDto->setLoadTime($leg->loadTime()->format(\DateTime::ISO8601));
            $legDto->setUnloadTime($leg->unloadTime()->format(\DateTime::ISO8601));

            $legs[] = $legDto;
        }

        $routeCandidate = new RouteCandidateDto();

        $routeCandidate->setLegs($legs);

        return $routeCandidate;
    }

    /**
     * @param RouteCandidateDto $aRouteCandidate
     * @return Itinerary
     */
    public function toItinerary(RouteCandidateDto $aRouteCandidate)
    {
        $legs = array();

        foreach ($aRouteCandidate->getLegs() as $legDto) {
            $legs[] = new Leg(
                $legDto->getLoadLocation(),
                $legDto->getUnloadLocation(),
                new \DateTime($legDto->getLoadTime()),
                new \DateTime($legDto->getUnloadTime())
            );
        }

        return new Itinerary($legs);
    }
}
 