<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 19:56
 */

namespace CodelinerTest\CargoBackend\Infrastructure\Routing;

use Codeliner\CargoBackend\Infrastructure\Routing\ExternalRoutingService;
use Codeliner\CargoBackend\Model\Cargo\RouteSpecification;
use CodelinerTest\CargoBackend\Mock\GraphTraversalServiceMock;
use CodelinerTest\CargoBackend\TestCase;

/**
 * Class ExternalRoutingServiceTest
 *
 * @package CodelinerTest\CargoBackend\Infrastructure\Routing
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ExternalRoutingServiceTest extends TestCase
{
    /**
     * @var ExternalRoutingService
     */
    private $externalRoutingService;

    protected function setUp()
    {
        $this->externalRoutingService = new ExternalRoutingService(new GraphTraversalServiceMock());
    }

    /**
     * @test
     */
    public function it_fetches_routes_for_specification()
    {
        $routeSpecification = new RouteSpecification('DEHAM', 'USNYC');

        $itineraries = $this->externalRoutingService->fetchRoutesForSpecification($routeSpecification);

        $this->assertEquals(1, count($itineraries));

        $itinerary = $itineraries[0];

        $this->assertInstanceOf('Codeliner\CargoBackend\Model\Cargo\Itinerary', $itinerary);

        $legs = $itinerary->legs();

        $this->assertEquals(1, count($legs));

        $leg = $legs[0];

        $this->assertInstanceOf('Codeliner\CargoBackend\Model\Cargo\Leg', $leg);

        $loadDate     = new \DateTime('2014-03-29 19:59:23');
        $unloadDate   = new \DateTime('2014-03-30 21:30:00');

        $this->assertEquals('DEHAM', $leg->loadLocation());
        $this->assertEquals('USNYC', $leg->unloadLocation());
        $this->assertEquals($loadDate->getTimestamp(), $leg->loadTime()->getTimestamp());
        $this->assertEquals($unloadDate->getTimestamp(), $leg->unloadTime()->getTimestamp());
    }
}
 