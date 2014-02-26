<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Cargo;

use Application\Domain\Model\Cargo\TrackingId;
use ApplicationTest\TestCase;
use Rhumsaa\Uuid\Uuid;

/**
 * TrackingIdTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TrackingIdTest extends TestCase
{
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
