<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 28.02.14 - 20:09
 */

namespace CodelinerTest\CargoBackend\Fixture;

use Codeliner\CargoBackend\Model\Cargo\Leg;

/**
 * Class LegFixture
 *
 * @package CodelinerTest\CargoBackend\Fixture
 * @author Alexander Miertsch <contact@prooph.de>
 */
class LegFixture 
{
    const HONGKONG_HAMBURG  = 'hongkong_hamburg';
    const HONGKONG_NEWYORK  = 'hongkong_newyork';
    const NEWYORK_HAMBURG   = 'newyork_hamburg';
    const HAMBURG_ROTTERDAM = 'hamburg_rotterdam';

    /**
     * @param string $aLegConstant
     * @return Leg
     */
    public static function get($aLegConstant)
    {
        switch($aLegConstant) {
            case self::HONGKONG_HAMBURG:
                return new Leg(
                    'Hongkong',
                    'Hamburg',
                    new \DateTimeImmutable('2014-01-20 10:00:00'),
                    new \DateTimeImmutable('2014-02-02 18:00:00')
                );
            case self::HONGKONG_NEWYORK:
                return new Leg(
                    'Hongkong',
                    'New York',
                    new \DateTimeImmutable('2014-01-20 10:00:00'),
                    new \DateTimeImmutable('2014-02-02 18:00:00')
                );
            case self::NEWYORK_HAMBURG:
                return new Leg(
                    'New York',
                    'Hamburg',
                    new \DateTimeImmutable('2014-02-20 10:00:00'),
                    new \DateTimeImmutable('2014-03-02 18:00:00')
                );
            case self::HAMBURG_ROTTERDAM:
                return new Leg(
                    'Hamburg',
                    'Rotterdam',
                    new \DateTimeImmutable('2014-03-10 10:00:00'),
                    new \DateTimeImmutable('2014-03-10 14:00:00')
                );

        }

    }
} 