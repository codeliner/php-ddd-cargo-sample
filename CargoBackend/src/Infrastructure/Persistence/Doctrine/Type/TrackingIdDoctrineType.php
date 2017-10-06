<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 06.12.15 - 17:25
 */

namespace Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\Type;

use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Ramsey\Uuid\Doctrine\UuidType;

/**
 * Class TrackingIdDoctrineType
 * Doctrine type of a a Cargo\TrackingId
 *
 * @package Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\Type
 */
final class TrackingIdDoctrineType extends UuidType
{
    const NAME = 'cargo_tracking_id';

    /**
     * {@inheritdoc}
     *
     * @param string|null                               $value
     * @param AbstractPlatform $platform
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?TrackingId
    {
        if (empty($value)) {
            return;
        }

        if ($value instanceof TrackingId) {
            return $value;
        }

        try {
            return TrackingId::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param TrackingId|null $value
     * @param AbstractPlatform $platform
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return;
        }

        if ($value instanceof TrackingId) {
            return $value->toString();
        }

        throw ConversionException::conversionFailed($value, self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return self::NAME;
    }
}
