<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CargoBackendTest\Infrastructure\Persistence\Doctrine;

use CargoBackendTest\Fixture\LegFixture;
use CargoBackendTest\TestCase;
use CargoBackend\Model\Cargo;
use CargoBackend\Model\Cargo\RouteSpecification;
/**
 *  CargoRepositoryDoctrineTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRepositoryDoctrineTest extends TestCase
{
    /**
     *
     * @var Cargo\CargoRepositoryInterface
     */
    protected $cargoRepository;
    
    protected function setUp()
    {
        $this->createEntitySchema('CargoBackend\Model\Cargo\Cargo');
        $this->createEntitySchema('CargoBackend\Model\Cargo\Itinerary');
        $this->createEntitySchema('CargoBackend\Model\Cargo\RouteSpecification');
        
        $this->cargoRepository = $this->getTestEntityManager()->getRepository('CargoBackend\Model\Cargo\Cargo');
    }

    /**
     * @test
     */
    public function it_returns_a_new_tracking_id()
    {
        $trackingId = $this->cargoRepository->getNextTrackingId();
        
        $this->assertInstanceOf('CargoBackend\Model\Cargo\TrackingId', $trackingId);
    }

    /**
     * @test
     */
    public function it_stores_and_returns_a_cargo()
    {
        $trackingId = $this->cargoRepository->getNextTrackingId();
        $routeSpecification = new RouteSpecification("Hongkong", "Hamburg");

        $cargo = new Cargo\Cargo($trackingId, $routeSpecification);

        $legs = [LegFixture::get(LegFixture::HONGKONG_NEWYORK), LegFixture::get(LegFixture::NEWYORK_HAMBURG)];

        $itinerary = new Cargo\Itinerary($legs);

        $cargo->assignToRoute($itinerary);

        $this->cargoRepository->store($cargo);

        $this->getTestEntityManager()->clear();
        
        $checkCargo = $this->cargoRepository->get($trackingId);
        
        $this->assertTrue($cargo->sameIdentityAs($checkCargo));

        $this->assertTrue($itinerary->sameValueAs($checkCargo->itinerary()));
    }
}
