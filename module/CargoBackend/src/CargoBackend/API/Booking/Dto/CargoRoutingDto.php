<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 16:59
 */

namespace CargoBackend\API\Booking\Dto;

/**
 * Class CargoRoutingDto
 *
 * @package CargoBackend\API\Booking\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRoutingDto 
{
    /**
     * @var string
     */
    private $trackingId;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $finalDestination;

    /**
     * @var LegDto[]
     */
    private $legs = array();

    /**
     * @param string $finalDestination
     */
    public function setFinalDestination($finalDestination)
    {
        \Assert\that($finalDestination)->notEmpty()->string();

        $this->finalDestination = $finalDestination;
    }

    /**
     * @return string
     */
    public function getFinalDestination()
    {
        return $this->finalDestination;
    }

    /**
     * @param LegDto[] $legs
     */
    public function setLegs($legs)
    {
        \Assert\that($legs)->all()->isInstanceOf('CargoBackend\API\Booking\Dto\LegDto');

        $this->legs = $legs;
    }

    public function addLeg(LegDto $leg)
    {
        $this->legs[] = $leg;
    }

    /**
     * @return LegDto[]
     */
    public function getLegs()
    {
        return $this->legs;
    }

    /**
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        \Assert\that($origin)->notEmpty()->string();

        $this->origin = $origin;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $trackingId
     */
    public function setTrackingId($trackingId)
    {
        \Assert\that($trackingId)->uuid();

        $this->trackingId = $trackingId;
    }

    /**
     * @return string
     */
    public function getTrackingId()
    {
        return $this->trackingId;
    }

    public function getArrayCopy()
    {
        $legsArrayCopy = array();

        foreach ($this->getLegs() as $leg) {
            $legsArrayCopy[] = array(
                'load_location'   => $leg->getLoadLocation(),
                'unload_location' => $leg->getUnloadLocation(),
                'load_time'       => $leg->getLoadTime(),
                'unload_time'     => $leg->getUnloadTime()
            );
        }

        return array(
            'tracking_id'        => $this->getTrackingId(),
            'origin'             => $this->getOrigin(),
            'final_destination'  => $this->getFinalDestination(),
            'legs'               => $legsArrayCopy
        );
    }
}
 