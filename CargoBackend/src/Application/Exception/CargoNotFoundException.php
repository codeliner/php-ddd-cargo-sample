<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:09
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Exception;

use Codeliner\CargoBackend\Model\Cargo\TrackingId;

/**
 * Class CargoNotFoundException
 *
 * @package CargoBackend\API\Exception
 * @author Alexander Miertsch <contact@prooph.de>
 */
class CargoNotFoundException extends \RuntimeException implements ApiException
{
    /**
     * @param TrackingId $aTrackingId
     * @return CargoNotFoundException
     */
    public static function forTrackingId(TrackingId $aTrackingId): self
    {
        return new self(sprintf(
            'Cargo with TrackingId -%s- can not be found.',
            $aTrackingId->toString()
        ));
    }
}
