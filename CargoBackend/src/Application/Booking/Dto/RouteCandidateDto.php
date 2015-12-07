<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:09
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Booking\Dto;

use Assert\Assertion;

class RouteCandidateDto
{
    /**
     * @var LegDto[]
     */
    private $legs;

    /**
     * @param LegDto[] $legs
     */
    public function setLegs(array $legs)
    {
        foreach($legs as $leg) {
            Assertion::isInstanceOf($leg, LegDto::class);
        }

        $this->legs = $legs;
    }

    /**
     * @return LegDto[]
     */
    public function getLegs(): array
    {
        return $this->legs;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
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
 