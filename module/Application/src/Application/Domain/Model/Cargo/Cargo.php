<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Cargo;

use Application\Domain\Shared\EntityInterface;
/**
 * A Cargo. This is the central class in the domain model.
 * 
 * A cargo is identified by a unique tracking id.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Cargo implements EntityInterface
{
    /**
     * Unique Identifier
     * 
     * @var TrackingId
     */
    protected $trackingId;

    /**
     * Construct
     * 
     * @param TrackingId $trackingId The Unique Identifier
     */
    public function __construct(TrackingId $trackingId)
    {
        $this->trackingId = $trackingId;
    }
    
    /**
     * Get the Unique Identifier of the Cargo
     * 
     * @return TrackingId
     */
    public function getTrackingId()
    {
        return $this->trackingId;
    }
        
    /**
     * {@inheritDoc}
     */
    public function sameIdentityAs(EntityInterface $other)
    {
        if (!$other instanceof Cargo) {
            return false;
        }
        
        return $this->getTrackingId()->sameValueAs($other->getTrackingId());
    }
}
