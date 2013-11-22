<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Cargo;

use Application\Domain\Shared\EntityInterface;
use Application\Domain\Shared\UID;
/**
 *  Cargo
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Cargo implements EntityInterface
{
    /**
     * Unique Identifier
     * 
     * @var UID
     */
    protected $uid;
    
    /**
     * Construct
     * 
     * @param UID $uid The Unique Identifier
     */
    public function __construct(UID $uid)
    {
        $this->uid = $uid;
    }
    
    /**
     * Get the Unique Identifier of the Cargo
     * 
     * @return UID
     */
    public function getUID()
    {
        return $this->uid;
    }

    /**
     * {@inheritDoc}
     */
    public function sameIdentityAs(EntityInterface $other)
    {
        if (!$other instanceof Cargo) {
            return false;
        }
        
        return $this->getUID()->sameValueAs($other->getUID());
    }
}
