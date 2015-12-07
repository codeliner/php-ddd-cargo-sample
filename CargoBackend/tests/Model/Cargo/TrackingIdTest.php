<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodelinerTest\CargoBackend\Domain\Model\Cargo;

use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use CodelinerTest\CargoBackend\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * TrackingIdTest
 * 
 * @author Alexander Miertsch <contact@prooph.de>
 */
class TrackingIdTest extends TestCase
{
    /**
     * @test
     */
    public function it_constructs_itself_from_string()
    {
        $uuid = Uuid::uuid4();

        $trackingId = TrackingId::fromString($uuid->toString());

        $this->assertEquals($uuid->toString(), $trackingId->toString());
    }
    /**
     * @test
     */
    public function it_returns_string_representation_of_uuid()
    {
        $uuid = Uuid::uuid4();

        $trackingId = new TrackingId($uuid);

        $this->assertEquals($uuid->toString(), $trackingId->toString());
    }

    /**
     * @test
     */
    public function it_is_same_value_as()
    {
        $uuid = Uuid::uuid4();

        $trackingId = new TrackingId($uuid);

        $sameTrackingId = new TrackingId($uuid);

        $this->assertTrue($trackingId->sameValueAs($sameTrackingId));
    }

    /**
     * @test
     */
    public function it_is_not_same_value_as()
    {
        $trackingId = new TrackingId(Uuid::uuid4());
        $otherTrackingId = new TrackingId(Uuid::uuid4());

        $this->assertFalse($trackingId->sameValueAs($otherTrackingId));
    }
}
