<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Cargo;

use Application\Domain\Shared\UID;
use Application\Domain\Shared\ValueObjectInterface;
use Zend\Validator\NotEmpty;
/**
 * TrackingId is the unique identifier of a Cargo
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TrackingId extends UID
{
    /**
     * Always provide a string representation of the TrackingId to construct the VO
     * 
     * @param string $trackingId
     * 
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($trackingId)
    {
        $notEmptyValidator = new NotEmpty();
        
        if (!$notEmptyValidator->isValid($trackingId)) {
            throw new Exception\InvalidArgumentException('TrackingId must not be empty.');
        }
        
        parent::__construct($trackingId);
    }
    
    /**
     * {@inheritDoc}
     */
    public function sameValueAs(ValueObjectInterface $other)
    {
        if (!$other instanceof TrackingId) {
            return false;
        }
        
        return parent::sameValueAs($other);
    }
}
