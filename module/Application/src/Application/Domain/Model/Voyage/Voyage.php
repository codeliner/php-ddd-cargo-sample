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
