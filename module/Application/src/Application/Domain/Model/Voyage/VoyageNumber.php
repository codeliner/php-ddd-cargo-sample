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
class VoyageNumber implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $id;

    public function __construct($anId)
    {
        if (!is_string($anId)) {
            throw new \InvalidArgumentException("VoyageNumber must be string");
        }

        $this->id = $anId;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
    /**
     * {@inheritDoc}
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof VoyageNumber) {
            return false;
        }
        
        return $this->toString() === $other->toString();
    }
}
