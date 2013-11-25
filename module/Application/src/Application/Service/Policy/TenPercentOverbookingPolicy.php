<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Service\Policy;

use Application\Domain\Model\Cargo\Cargo;
use Application\Domain\Model\Voyage\Voyage;
/**
 *  TenPercentOverbookingPolicy
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TenPercentOverbookingPolicy implements OverbookingPolicyInterface
{
    public function isAllowed(Cargo $cargo, Voyage $voyage)
    {
        $overbookingCapacity = $voyage->getCapacity() * 1.1;
        $bookedCapacity = $voyage->getCapacity() - $voyage->getFreeCapacity();        
        $freeWithOverbookingCapacity = $overbookingCapacity - $bookedCapacity;
        
        if ($cargo->getSize() > $freeWithOverbookingCapacity) {
            return false;
        }
        
        return true;
    }

}
