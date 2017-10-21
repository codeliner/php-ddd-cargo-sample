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

use Assert\Assert;
use Assert\Assertion;

/**
 * Class CargoRoutingDto
 *
 * @package CargoBackend\API\Booking\Dto
 * @author  Alexander Miertsch <contact@prooph.de>
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
     * @param string   $trackingId
     * @param string   $origin
     * @param string   $finalDestination
     * @param LegDto[] $legs
     */
    public function __construct(string $trackingId, string $origin, string $finalDestination, array $legs)
    {
        $this->setTrackingId($trackingId);
        $this->setOrigin($origin);
        $this->setFinalDestination($finalDestination);
        $this->setLegs($legs);
    }

    /**
     * @return string
     */
    public function getTrackingId(): string
    {
        return $this->trackingId;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function getFinalDestination(): string
    {
        return $this->finalDestination;
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
            'tracking_id'       => $this->getTrackingId(),
            'origin'            => $this->getOrigin(),
            'final_destination' => $this->getFinalDestination(),
            'legs'              => $legsArrayCopy
        );
    }

    /**
     * @param string $trackingId
     */
    private function setTrackingId(string $trackingId): void
    {
        Assertion::uuid($trackingId);

        $this->trackingId = $trackingId;
    }

    /**
     * @param string $origin
     */
    private function setOrigin(string $origin): void
    {
        Assertion::notEmpty($origin);

        $this->origin = $origin;
    }

    /**
     * @param string $finalDestination
     */
    private function setFinalDestination(string $finalDestination): void
    {
        Assert::that($finalDestination)->notEmpty()->string();

        $this->finalDestination = $finalDestination;
    }

    /**
     * @param LegDto[] $legs
     */
    private function setLegs(array $legs)
    {
        $this->legs = array();

        foreach ($legs as $leg) {
            $this->addLeg($leg);
        }
    }

    /**
     * @param LegDto $leg
     */
    private function addLeg(LegDto $leg): void
    {
        $this->legs[] = $leg;
    }
}
