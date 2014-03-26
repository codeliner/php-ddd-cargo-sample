<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:04
 */

namespace CargoBackend\API\Dto;

use Assert\Assertion;

/**
 * Class TrackingIdDto
 *
 * @package CargoBackend\API\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TrackingIdDto 
{
    /**
     * @var string
     */
    private $trackingId;

    /**
     * @param string $trackingId
     */
    public function setTrackingId($trackingId)
    {
        Assertion::uuid($trackingId);
        $this->trackingId = $trackingId;
    }

    /**
     * @return string
     */
    public function getTrackingId()
    {
        return $this->trackingId;
    }
}
 