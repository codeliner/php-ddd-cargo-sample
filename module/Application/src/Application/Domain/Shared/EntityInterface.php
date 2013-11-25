<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Shared;

/**
 *  An entity, as explained in the DDD book.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface EntityInterface
{
    /**
   * Entities compare by identity, not by attributes.
   *
   * @param EntityInterface $other The other entity.
   * @return boolean True if the identities are the same, regardles of other attributes.
   */
    public function sameIdentityAs(EntityInterface $other);
}
