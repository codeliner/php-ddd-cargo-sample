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
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
/**
 * A Cargo. This is the central class in the domain model.
 * 
 * A cargo is identified by a unique tracking id.
 * 
 * ---Annotations required by Doctrine---
 * @Entity(repositoryClass="Application\Infrastructure\Persistence\Doctrine\CargoRepositoryDoctrine")
 * @Table(name="cargo")
 * --------------------------------------
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Cargo implements EntityInterface
{
    /**
     * Unique Identifier
     * 
     * ---Annotations required by Doctrine---
     * @Id
     * @Column(type="trackingid", length=13, unique=true, nullable=false)
     * --------------------------------------
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
