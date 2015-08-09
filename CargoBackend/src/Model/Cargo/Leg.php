<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Codeliner\CargoBackend\Model\Cargo;

use Codeliner\CargoBackend\Model\Voyage\Voyage;
use Codeliner\Domain\Shared\ValueObjectInterface;
use Codeliner\Comparison\EqualsBuilder;

/**
 * Class Leg
 *
 * A Leg is part of an Itinerary. It describes a voyage from one location to another, with concrete load und unload times.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Leg implements ValueObjectInterface
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
     * @param ValueObjectInterface $other
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof Leg) {
            return false;
        }
        
        return EqualsBuilder::create()
            ->append($this->loadLocation(), $other->loadLocation())
            ->append($this->unloadLocation(), $other->unloadLocation())
            ->append($this->loadTime()->getTimestamp(), $other->loadTime()->getTimestamp())
            ->append($this->unloadTime()->getTimestamp(), $other->unloadTime()->getTimestamp())
            ->equals();
    }

}
