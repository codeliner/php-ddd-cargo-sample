<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Cargo;

use Application\Domain\Model\Cargo\Itinerary;
use Application\Domain\Model\Cargo\Leg;
use ApplicationTest\TestCase;
use Application\Domain\Model\Cargo\Cargo;
use Application\Domain\Model\Cargo\TrackingId;
use Application\Domain\Shared\UID;
use Application\Domain\Model\Cargo\RouteSpecification;
/**
 *  CargoTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_its_tracking_id()
    {
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId($uid->toString()), $routeSpecification);

        $checkTrackingId = new TrackingId($uid->toString());

        $this->assertTrue($checkTrackingId->sameValueAs($cargo->trackingId()));
    }

    /**
     * @test
     */
    public function it_returns_initial_route_specification()
    {
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId($uid->toString()), $routeSpecification);

        $this->assertEquals('Hongkong', $cargo->routeSpecification()->origin());
        $this->assertEquals('Hamburg', $cargo->routeSpecification()->destination());
    }

    /**
     * @test
     */
    public function it_takes_origin_from_initial_route_specification()
    {
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId($uid->toString()), $routeSpecification);
        
        $this->assertEquals("Hongkong", $cargo->origin());
    }

    /**
     * @test
     */
    public function it_specifies_new_route_but_do_not_change_the_origin()
    {
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId($uid->toString()), $routeSpecification);

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
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo = new Cargo(new TrackingId($uid->toString()), $routeSpecification);

        $legs = [new Leg('Hongkong', 'New York'), new Leg('New York', 'Hamburg')];

        $itinerary = new Itinerary($legs);

        $cargo->assignToRoute($itinerary);

        $this->assertTrue($itinerary->sameValueAs($cargo->itinerary()));
    }

    /**
     * @test
     */
    public function it_detects_same_tracking_id()
    {
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo1 = new Cargo(new TrackingId($uid->toString()), $routeSpecification);
        $cargo2 = new Cargo(new TrackingId($uid->toString()), $routeSpecification);
        
        $this->assertTrue($cargo1->sameIdentityAs($cargo2));
        
        $uid2 = new UID();
        $routeSpecification2 = new RouteSpecification("New York", "Melburne");
        
        $cargo3 = new Cargo(new TrackingId($uid2->toString()), $routeSpecification2);
        
        $this->assertFalse($cargo1->sameIdentityAs($cargo3));
    }

    /**
     * @test
     */
    public function it_detects_different_tracking_id()
    {
        $uid = new UID();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");
        $cargo1 = new Cargo(new TrackingId($uid->toString()), $routeSpecification);

        $uid2 = new UID();
        $otherCargo = new Cargo(new TrackingId($uid2->toString()), $routeSpecification);

        $this->assertFalse($cargo1->sameIdentityAs($otherCargo));
    }
}
