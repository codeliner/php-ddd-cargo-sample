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
use Application\Domain\Model\Voyage\Voyage;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
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
     * Size of the Cargo
     * 
     * ---Annotations required by Doctrine---
     * @Column(type="integer")
     * --------------------------------------
     * 
     * @var integer 
     */
    protected $size;
    
    /**
     * The booked Voyage
     * 
     * --Annotations required by Doctrine----
     * @ManyToOne(targetEntity="Application\Domain\Model\Voyage\Voyage", inversedBy="bookedCargos", fetch="LAZY")
     * @JoinColumn(name="voyage_number", referencedColumnName="voyage_number")
     * --------------------------------------
     * 
     * @var Voyage
     */
    protected $voyage;

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
     * Get the size of the Cargo.
     * 
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the size of the Cargo.
     * 
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * 
     * @return Voyage
     */
    public function getVoyage()
    {
        return $this->voyage;
    }

    /**
     * 
     * @param Voyage $voyage
     * @return void
     */
    public function setVoyage(Voyage $voyage)
    {
        $this->voyage = $voyage;
    }
    
    /**
     * Check if Cargo is already booked
     * 
     * @return boolean
     */
    public function isBooked()
    {
        return !is_null($this->getVoyage());
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
