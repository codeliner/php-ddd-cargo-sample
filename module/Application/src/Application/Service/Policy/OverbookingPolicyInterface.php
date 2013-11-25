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
 * Interface of an OverbookingPolicy
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface OverbookingPolicyInterface
{
    /**
     * Check if Voyage has enough capacity (including overbooking capacity) for given Cargo
     */
    public function isAllowed(Cargo $cargo, Voyage $voyage);
}
