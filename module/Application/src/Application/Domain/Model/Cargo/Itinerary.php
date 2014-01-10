<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Cargo;

use Application\Domain\Shared\ValueObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Domain\Model\Cargo\Leg;
/**
 *  Itinerary
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Itinerary implements ValueObjectInterface
{
    /**
     *
     * @var ArrayCollection
     */
    protected $legs;
    
    public function __construct(ArrayCollection $legs)
    {
        $this->legs = $legs;
    }
    
    /**
     * 
     * @return ArrayCollection
     */
    public function legs()
    {
        return $this->legs;
    }
    
    
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof Itinerary) {
            return false;
        }
        
        if ($this->legs()->count() !== $other->legs->count()) {
            return false;
        }
        
        return $this->legs->forAll(function($index, Leg $leg) use ($other) {
           return $other->legs()->exists(function($otherIndex, Leg $otherLeg) use ($leg) {
               return $otherLeg->sameValueAs($leg);
           });
        });
    }
}
