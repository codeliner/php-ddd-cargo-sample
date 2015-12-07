<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Model\Cargo;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * TrackingId is the unique identifier of a Cargo
 * 
 * @author Alexander Miertsch <contact@prooph.de>
 */
class TrackingId
{
    /**
     * @param string $aTrackingId
     * @return TrackingId
     */
    public static function fromString(string $aTrackingId): TrackingId
    {
        return new self(Uuid::fromString($aTrackingId));
    }

    /**
     * @return TrackingId
     */
    public static function generate(): TrackingId
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * Always provide a string representation of the TrackingId to construct the VO
     * 
     * @param UuidInterface $aUuid
     * 
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(UuidInterface $aUuid)
    {
        $this->uuid = $aUuid;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @param TrackingId $other
     * @return bool
     */
    public function sameValueAs(TrackingId $other): bool
    {
        return $this->toString() === $other->toString();
    }
}
