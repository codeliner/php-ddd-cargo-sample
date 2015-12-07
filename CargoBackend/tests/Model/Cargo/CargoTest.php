<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodelinerTest\CargoBackend\Domain\Model\Cargo;

use Codeliner\CargoBackend\Model\Cargo\Itinerary;
use CodelinerTest\CargoBackend\Fixture\LegFixture;
use CodelinerTest\CargoBackend\TestCase;
use Codeliner\CargoBackend\Model\Cargo\Cargo;
use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use Codeliner\CargoBackend\Model\Cargo\RouteSpecification;
use Ramsey\Uuid\Uuid;

/**
 *  CargoTest
 * 
 * @author Alexander Miertsch <contact@prooph.de>
 */
class CargoTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_its_tracking_id()
    {
        $uuid = Uuid::uuid4();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId($uuid), $routeSpecification);

        $checkTrackingId = new TrackingId($uuid);

        $this->assertTrue($checkTrackingId->sameValueAs($cargo->trackingId()));
    }

    /**
     * @test
     */
    public function it_returns_initial_route_specification()
    {
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId(Uuid::uuid4()), $routeSpecification);

        $this->assertEquals('Hongkong', $cargo->routeSpecification()->origin());
        $this->assertEquals('Hamburg', $cargo->routeSpecification()->destination());
    }

    /**
     * @test
     */
    public function it_takes_origin_from_initial_route_specification()
    {
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId(Uuid::uuid4()), $routeSpecification);
        
        $this->assertEquals("Hongkong", $cargo->origin());
    }

    /**
     * @test
     */
    public function it_specifies_new_route_but_do_not_change_the_origin()
    {
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId(Uuid::uuid4()), $routeSpecification);

        $anotherRouteSpecification = new RouteSpecification("Dallas", "Rotterdam");

        $cargo->specifyNewRoute($anotherRouteSpecification);

        $this->assertEquals('Dallas', $cargo->routeSpecification()->origin());
        $this->assertEquals('Rotterdam', $cargo->routeSpecification()->destination());
        $this->assertEquals('Hongkong', $cargo->origin());
    }

    /**
     * @test
     */
    public function it_assigns_cargo_to_route_described_by_itinerary()
    {
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId(Uuid::uuid4()), $routeSpecification);

        $legs = [LegFixture::get(LegFixture::HONGKONG_NEWYORK), LegFixture::get(LegFixture::NEWYORK_HAMBURG)];

        $itinerary = new Itinerary($legs);

        $cargo->assignToRoute($itinerary);

        $this->assertTrue($itinerary->sameValueAs($cargo->itinerary()));
    }

    /**
     * @test
     */
    public function it_detects_same_tracking_id()
    {
        $uuid = Uuid::uuid4();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo1 = new Cargo(new TrackingId($uuid), $routeSpecification);
        $cargo2 = new Cargo(new TrackingId($uuid), $routeSpecification);
        
        $this->assertTrue($cargo1->sameIdentityAs($cargo2));
        
        $uuid2 = Uuid::uuid4();
        $routeSpecification2 = new RouteSpecification("New York", "Melburne");
        
        $cargo3 = new Cargo(new TrackingId($uuid2), $routeSpecification2);
        
        $this->assertFalse($cargo1->sameIdentityAs($cargo3));
    }

    /**
     * @test
     */
    public function it_detects_different_tracking_id()
    {
        $uuid = Uuid::uuid4();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo1 = new Cargo(new TrackingId($uuid), $routeSpecification);

        $uuid2 = Uuid::uuid4();
        $otherCargo = new Cargo(new TrackingId($uuid2), $routeSpecification);

        $this->assertFalse($cargo1->sameIdentityAs($otherCargo));
    }
}
