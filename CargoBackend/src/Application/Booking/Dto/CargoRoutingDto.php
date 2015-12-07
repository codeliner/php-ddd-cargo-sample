<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 16:59
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Booking\Dto;
use Assert\Assertion;

/**
 * Class CargoRoutingDto
 *
 * @package CargoBackend\API\Booking\Dto
 * @author Alexander Miertsch <contact@prooph.de>
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
    public function setFinalDestination(string $finalDestination)
    {
        \Assert\that($finalDestination)->notEmpty()->string();

        $this->finalDestination = $finalDestination;
    }

    /**
     * @return string
     */
    public function getFinalDestination(): string
    {
        return $this->finalDestination;
    }

    /**
     * @param LegDto[] $legs
     */
    public function setLegs(array $legs): array
    {
        foreach($legs as $leg) {
            Assertion::isInstanceOf($leg, LegDto::class);
        }

        $this->legs = $legs;
    }

    public function addLeg(LegDto $leg)
    {
        $this->legs[] = $leg;
    }

    /**
     * @return LegDto[]
     */
    public function getLegs(): array
    {
        return $this->legs;
    }

    /**
     * @param string $origin
     */
    public function setOrigin(string $origin)
    {
        Assertion::notEmpty($origin);

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
    public function setTrackingId(string $trackingId)
    {
        Assertion::uuid($trackingId);

        $this->trackingId = $trackingId;
    }

    /**
     * @return string
     */
    public function getTrackingId(): string
    {
        return $this->trackingId;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
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
 