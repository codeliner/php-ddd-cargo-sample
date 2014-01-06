<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Infrastructure\Persistence\Doctrine;

use ApplicationTest\TestCase;
use Application\Domain\Model\Cargo;
use Application\Infrastrucure\Persistence\Doctrine\CargoRepositoryDoctrine;
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
        $this->createEntitySchema('Application\Domain\Model\Cargo\Cargo');
        
        $this->cargoRepository = $this->getTestEntityManager()->getRepository('Application\Domain\Model\Cargo\Cargo');
    }
    
    public function testGetNextTrackingId()
    {
        $trackingId = $this->cargoRepository->getNextTrackingId();
        
        $this->assertInstanceOf('Application\Domain\Model\Cargo\TrackingId', $trackingId);
    }
    
    public function testStoreAndFindCargo()
    {
        $trackingId = $this->cargoRepository->getNextTrackingId();
        $cargo = new Cargo\Cargo($trackingId);
        
        $this->cargoRepository->store($cargo);
        
        $checkCargo = $this->cargoRepository->findCargo($trackingId);
        
        $this->assertTrue($cargo->sameIdentityAs($checkCargo));
    }
}
