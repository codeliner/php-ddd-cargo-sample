<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:21
 */

namespace CargoBackend\API\Dto;

/**
 * Class ItineraryDto
 *
 * @package CargoBackend\API\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ItineraryDto 
{
    /**
     * @var LegDto[]
     */
    private $legs = array();

    /**
     * @param \CargoBackend\API\Dto\LegDto[] $legs
     */
    public function setLegs(array $legs)
    {
        \Assert\that($legs)->all()->isInstanceOf('CargoBackend\API\Dto\LegDto');

        $this->legs = $legs;
    }

    /**
     * @param LegDto $leg
     */
    public function addLeg(LegDto $leg)
    {
        $this->legs[] = $leg;
    }

    /**
     * @return \CargoBackend\API\Dto\LegDto[]
     */
    public function getLegs()
    {
        return $this->legs;
    }
}
 