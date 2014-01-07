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
/**
 *  RouteSpecification
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteSpecification implements ValueObjectInterface
{
    /**
     * Origin Location
     * 
     * @var string 
     */
    protected $origin;
    
    /**
     * Destination Location
     * 
     * @var string 
     */
    protected $destination;
    
    /**
     * Customs clearance point
     * 
     * @var string 
     */
    protected $customsClearancePoint;
    
    public function __construct($origin, $destination, $customsClearancePoint = null)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->customsClearancePoint = $customsClearancePoint;
    }
    
    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getCustomsClearancePoint()
    {
        return $this->customsClearancePoint;
    }

    public function sameValueAs(ValueObjectInterface $other)
    {
        if ($other instanceof RouteSpecification) {
            if ($this->getOrigin() == $other->getOrigin()
                && $this->getDestination() == $other->getDestination()
                && $this->getCustomsClearancePoint() == $other->getCustomsClearancePoint()) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Surrogate key, required by Doctrine
     * 
     * @var string 
     */
    private $id;
}
