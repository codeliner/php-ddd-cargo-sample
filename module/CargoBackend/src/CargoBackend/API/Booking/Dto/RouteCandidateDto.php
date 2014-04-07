<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:09
 */

namespace CargoBackend\API\Booking\Dto;

class RouteCandidateDto 
{
    /**
     * @var LegDto[]
     */
    private $legs;

    /**
     * @param LegDto[] $legs
     */
    public function setLegs($legs)
    {
        \Assert\that($legs)->all()->isInstanceOf('CargoBackend\API\Booking\Dto\LegDto');

        $this->legs = $legs;
    }

    /**
     * @return LegDto[]
     */
    public function getLegs()
    {
        return $this->legs;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $legsList = array();

        foreach ($this->getLegs() as $leg) {
            $legsList[] = array(
                'load_location'   => $leg->getLoadLocation(),
                'unload_location' => $leg->getUnloadLocation(),
                'load_time'       => $leg->getLoadTime(),
                'unload_time'     => $leg->getUnloadTime()
            );
        }

        return array('legs' => $legsList);
    }
}
 