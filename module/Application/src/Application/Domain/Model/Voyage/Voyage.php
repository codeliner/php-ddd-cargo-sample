<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Voyage;

use Application\Domain\Shared\EntityInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
/**
 * A Voyage. Cargos can be booked on a Voyage.
 * 
 * A Voyage is identified by a unique voyage number.
 * 
 * ---Annotations required by Doctrine---
 * @Entity(repositoryClass="Application\Infrastructure\Persistence\Doctrine\VoyageRepositoryDoctrine")
 * @Table(name="voyage")
 * --------------------------------------
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Voyage implements EntityInterface
{
    /**
     * Unique Identifier
     * 
     * ---Annotations required by Doctrine---
     * @Id
     * @Column(type="voyagenumber", length=30, unique=true, nullable=false)
     * --------------------------------------
     * 
     * @var VoyageNumber
     */
    protected $voyageNumber;
    
    /**
     * Name of the voyage
     * 
     * ---Annotations required by Doctrine---
     * @Column(type="string", length=100)
     * --------------------------------------
     * 
     * @var integer 
     */
    protected $name;
    
    /**
     * Capacity of the Voyage
     * 
     * ---Annotations required by Doctrine---
     * @Column(type="integer")
     * --------------------------------------
     * 
     * @var integer 
     */
    protected $capacity;
    
    /**
     * Construct
     * 
     * @param VoyageNumber $voyageNumber
     */
    public function __construct(VoyageNumber $voyageNumber)
    {
        $this->voyageNumber = $voyageNumber;
    }
    
    /**
     * Get the unique id
     * 
     * @return VoyageNumber
     */
    public function getVoyageNumber()
    {
        return $this->voyageNumber;
    }
    
    /**
     * Get name of the Voyage
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get capacity of Voyage
     * 
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set name of Voyage
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get capacity of Voyage
     * 
     * @param integer $capacity
     * @return void
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

        
    /**
     * {@inheritDoc}
     */
    public function sameIdentityAs(EntityInterface $other)
    {
        if (!$other instanceof Voyage) {
            return false;
        }
        
        return $this->getVoyageNumber()->sameValueAs($other->getVoyageNumber());
    }
}
