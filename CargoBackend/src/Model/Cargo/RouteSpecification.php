<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Model\Cargo;

/**
 *  RouteSpecification
 *
 * Describes where a cargo origin and destination is.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteSpecification
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
    public function origin(): string
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function destination(): string
    {
        return $this->destination;
    }

    /**
     * @param RouteSpecification $other
     * @return bool
     */
    public function sameValueAs(RouteSpecification $other): bool
    {
        if ($this->origin() !== $other->origin()) {
            return false;
        }

        if ($this->destination() !== $other->destination()) {
            return false;
        }

        return true;
    }
    
    /**
     * Surrogate key, required by Doctrine
     * 
     * @var string 
     */
    private $id;
}
