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
     * @param string $unloadLocation
     * @param string $loadTime
     * @param string $unloadTime
     */
    public function __construct(string $loadLocation, string $unloadLocation, string $loadTime, string $unloadTime)
    {
        $this->setLoadLocation($loadLocation);
        $this->setUnloadLocation($unloadLocation);
        $this->setLoadTime($loadTime);
        $this->setUnloadTime($unloadTime);
    }

    /**
     * @return string
     */
    public function getLoadLocation(): string
    {
        return $this->loadLocation;
    }

    /**
     * @return string
     */
    public function getLoadTime(): string
    {
        return $this->loadTime;
    }

    /**
     * @return string
     */
    public function getUnloadLocation(): string
    {
        return $this->unloadLocation;
    }

    /**
     * @return string
     */
    public function getUnloadTime(): string
    {
        return $this->unloadTime;
    }

    /**
     * @param string $loadLocation
     */
    private function setLoadLocation(string $loadLocation): void
    {
        Assertion::notEmpty($loadLocation);

        $this->loadLocation = $loadLocation;
    }

    /**
     * @param string $loadTime
     */
    private function setLoadTime(string $loadTime): void
    {
        Assertion::notEmpty($loadTime);

        $this->loadTime = $loadTime;
    }

    /**
     * @param string $unloadLocation
     */
    private function setUnloadLocation(string $unloadLocation): void
    {
        Assertion::notEmpty($unloadLocation);

        $this->unloadLocation = $unloadLocation;
    }

    /**
     * @param string $unloadTime
     */
    private function setUnloadTime(string $unloadTime): void
    {
        Assertion::notEmpty($unloadTime);

        $this->unloadTime = $unloadTime;
    }
}
