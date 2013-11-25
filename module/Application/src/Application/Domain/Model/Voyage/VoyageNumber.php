<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Voyage;

use Application\Domain\Shared\UID;
use Application\Domain\Shared\ValueObjectInterface;
/**
 * Unique identifier of a Voyage
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageNumber extends UID implements ValueObjectInterface
{
    /**
     * {@inheritDoc}
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof VoyageNumber) {
            return false;
        }
        
        return parent::sameValueAs($other);
    }
}
