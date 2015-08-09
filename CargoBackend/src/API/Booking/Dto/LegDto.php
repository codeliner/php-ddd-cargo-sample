<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:22
 */

namespace Codeliner\CargoBackend\API\Booking\Dto;

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
    public function setLoadLocation($loadLocation)
    {
        \Assert\that($loadLocation)->notEmpty()->string();

        $this->loadLocation = $loadLocation;
    }

    /**
     * @return string
     */
    public function getLoadLocation()
    {
        return $this->loadLocation;
    }

    /**
     * @param string $loadTime
     */
    public function setLoadTime($loadTime)
    {
        \Assert\that($loadTime)->notEmpty()->string();

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
    public function setUnloadLocation($unloadLocation)
    {
        \Assert\that($unloadLocation)->notEmpty()->string();

        $this->unloadLocation = $unloadLocation;
    }

    /**
     * @return string
     */
    public function getUnloadLocation()
    {
        return $this->unloadLocation;
    }

    /**
     * @param string $unloadTime
     */
    public function setUnloadTime($unloadTime)
    {
        \Assert\that($unloadTime)->notEmpty()->string();

        $this->unloadTime = $unloadTime;
    }

    /**
     * @return string
     */
    public function getUnloadTime()
    {
        return $this->unloadTime;
    }


}
 