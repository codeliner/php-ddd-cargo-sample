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
use Codeliner\Comparison\EqualsBuilder;
/**
 * Class Leg
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Leg implements ValueObjectInterface
{
    private $loadLocation;
    private $unloadLocation;
    
    public function __construct($loadLocation, $unloadLocation)
    {
        $this->loadLocation = $loadLocation;
        $this->unloadLocation = $unloadLocation;
    }
    
    public function loadLocation()
    {
        return $this->loadLocation;
    }
    
    public function unloadLocation()
    {
        return $this->unloadLocation;
    }
    
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof Leg) {
            return false;
        }
        
        return EqualsBuilder::create()
            ->append($this->loadLocation(), $other->loadLocation())
            ->append($this->unloadLocation(), $other->unloadLocation())
            ->equals();
    }

}
