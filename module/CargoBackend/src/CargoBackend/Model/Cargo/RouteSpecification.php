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
use Codeliner\Comparison\EqualsBuilder;

/**
 *  RouteSpecification
 *
 * Describes where a cargo origin and destination is.
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
     * @param string $origin
     * @param string $destination
     */
    public function __construct($origin, $destination)
    {
        $this->origin = $origin;
        $this->destination = $destination;
    }
    
    /**
     * @return string
     */
    public function origin()
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function destination()
    {
        return $this->destination;
    }

    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof RouteSpecification) {
            return false;
        }
        
        return EqualsBuilder::create()
            ->append($this->origin(), $other->origin())
            ->append($this->destination(), $other->destination())
            ->equals();
    }
    
    /**
     * Surrogate key, required by Doctrine
     * 
     * @var string 
     */
    private $id;
}
