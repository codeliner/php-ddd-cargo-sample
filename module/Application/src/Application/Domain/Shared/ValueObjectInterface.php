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
 * A value object, as described in the DDD book.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface ValueObjectInterface
{
    /**
     * Value objects compare by the values of their attributes, they don't have an identity.
     * 
     * @param ValueObject $other The other value object.
     * @return boolean True if the given value object's and this value object's attributes are the same.
     */
    public function sameValueAs(ValueObjectInterface $other);
}
