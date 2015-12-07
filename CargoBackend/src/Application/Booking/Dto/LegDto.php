<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:22
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Booking\Dto;

use Assert\Assertion;

class LegDto
{
    /**
     * @var string
     */
    private $loadLocation;

    /**
     * @var string
     */
    private $unloadLocation;

    /**
     * @var string ISO8601 Date
     */
    private $loadTime;

    /**
     * @var string ISO8601 Date
     */
    private $unloadTime;

    /**
     * @param string $loadLocation
     */
    public function setLoadLocation(string $loadLocation)
    {
        Assertion::notEmpty($loadLocation);

        $this->loadLocation = $loadLocation;
    }

    /**
     * @return string
     */
    public function getLoadLocation(): string
    {
        return $this->loadLocation;
    }

    /**
     * @param string $loadTime
     */
    public function setLoadTime(string $loadTime)
    {
        Assertion::notEmpty($loadTime);

        $this->loadTime = $loadTime;
    }

    /**
     * @return string
     */
    public function getLoadTime()
    {
        return $this->loadTime;
    }

    /**
     * @param string $unloadLocation
     */
    public function setUnloadLocation(string $unloadLocation)
    {
        Assertion::notEmpty($unloadLocation);

        $this->unloadLocation = $unloadLocation;
    }

    /**
     * @return string
     */
    public function getUnloadLocation(): string
    {
        return $this->unloadLocation;
    }

    /**
     * @param string $unloadTime
     */
    public function setUnloadTime(string $unloadTime)
    {
        Assertion::notEmpty($unloadTime);

        $this->unloadTime = $unloadTime;
    }

    /**
     * @return string
     */
    public function getUnloadTime(): string
    {
        return $this->unloadTime;
    }


}
 