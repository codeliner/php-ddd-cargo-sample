<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CargoBackend\Model\Cargo;

use Codeliner\Domain\Shared\ValueObjectInterface;
use Rhumsaa\Uuid\Uuid;

/**
 * TrackingId is the unique identifier of a Cargo
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TrackingId implements ValueObjectInterface
{
    /**
     * @param string $aTrackingId
     * @return TrackingId
     */
    public static function fromString($aTrackingId)
    {
        return new self(Uuid::fromString($aTrackingId));
    }

    /**
     * @var Uuid
     */
    private $uuid;
    /**
     * Always provide a string representation of the TrackingId to construct the VO
     * 
     * @param Uuid $aUuid
     * 
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(Uuid $aUuid)
    {
        $this->uuid = $aUuid;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->uuid->toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * {@inheritDoc}
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof TrackingId) {
            return false;
        }
        
        return $this->toString() === $other->toString();
    }
}
