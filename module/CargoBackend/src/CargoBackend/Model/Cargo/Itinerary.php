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
use CargoBackend\Model\Cargo\Leg;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *  Itinerary
 *
 * The Itinerary is a ValueObject that describes a route of a cargo.
 * It is composed of one or more Legs.
 * Each Leg describes a part of the entire route, f.e. from one port to another.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Itinerary implements ValueObjectInterface
{
    /**
     * @var Leg[]
     */
    protected $legs;

    /**
     * @param Leg[] $legs
     */
    public function __construct(array $legs)
    {
        $this->legs = $legs;
    }
    
    /**
     * @return Leg[] Immutable list of Legs
     */
    public function legs()
    {
        return $this->legs;
    }

    /**
     * @param ValueObjectInterface $other
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof Itinerary) {
            return false;
        }

        //We use doctrine's ArrayCollection only to ease comparison
        //If Legs would be stored in an ArrayCollection hole the time
        //Itinerary itself would not be immutable,
        //cause a client could call $itinerary->legs()->add($anotherLeg);
        //Keeping ValueObjects immutable is a rule of thumb
        $myLegs = new ArrayCollection($this->legs());
        $otherLegs = new ArrayCollection($other->legs());
        
        if ($myLegs->count() !== $otherLegs->count()) {
            return false;
        }
        
        return $myLegs->forAll(function($index, Leg $leg) use ($otherLegs) {
           return $otherLegs->exists(function($otherIndex, Leg $otherLeg) use ($leg) {
               return $otherLeg->sameValueAs($leg);
           });
        });
    }

    /**
     * surrogate key, required by doctrine
     */
    private $id;
}
