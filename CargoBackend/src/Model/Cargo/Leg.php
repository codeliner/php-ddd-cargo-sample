<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Model\Cargo;

/**
 * Class Leg
 *
 * A Leg is part of an Itinerary. It describes a voyage from one location to another, with concrete load und unload times.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Leg
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
     * @var \DateTime
     */
    private $loadTime;

    /**
     * @var \DateTime
     */
    private $unloadTime;

    /**
     * @param string    $aLoadLocation
     * @param string    $anUnloadLocation
     * @param \DateTime $aLoadTime
     * @param \DateTime $anUnloadTime
     */
    public function __construct($aLoadLocation,
                                $anUnloadLocation,
                                \DateTime $aLoadTime,
                                \DateTime $anUnloadTime)
    {
       $this->loadLocation   = $aLoadLocation;
        $this->unloadLocation = $anUnloadLocation;
        $this->loadTime       = $aLoadTime;
        $this->unloadTime     = $anUnloadTime;
    }

    /**
     * @return string
     */
    public function loadLocation()
    {
        return $this->loadLocation;
    }

    /**
     * @return string
     */
    public function unloadLocation()
    {
        return $this->unloadLocation;
    }

    /**
     * @return \DateTime
     */
    public function loadTime()
    {
        return $this->loadTime;
    }

    /**
     * @return \DateTime
     */
    public function unloadTime()
    {
        return $this->unloadTime;
    }

    /**
     * @param Leg $other
     * @return bool
     */
    public function sameValueAs(Leg $other)
    {
        if ($this->loadLocation() !== $other->loadLocation()) {
            return false;
        }

        if ($this->unloadLocation() !== $other->unloadLocation()) {
            return false;
        }

        if ($this->loadTime() != $other->loadTime()) {
            return false;
        }

        if ($this->unloadTime() != $other->unloadTime()) {
            return false;
        }

        return true;
    }

}
