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
 * Unique Identifier
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class UID implements ValueObjectInterface
{
    /**
     * String representation of the unique identifier
     * 
     * @var string
     */
    protected $uid;
    
    /**
     * Construct
     * 
     * @param string $uid If $uid is null, a new unique id will be generated
     */
    public function __construct($uid = null)
    {
        if (is_null($uid)) {
            $uid = uniqid();
        }
        
        $this->uid = $uid;
    }

    /**
     * {@inheritDoc}
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof UID) {
            return false;
        }
        
        return $this->toString() === $other->toString();
    }
    
    /**
     * Get string representation of UID
     * 
     * @return string
     */
    public function toString()
    {
        return $this->uid;
    }
    
    /**
     * Magic toString, same as {@see toString}
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
