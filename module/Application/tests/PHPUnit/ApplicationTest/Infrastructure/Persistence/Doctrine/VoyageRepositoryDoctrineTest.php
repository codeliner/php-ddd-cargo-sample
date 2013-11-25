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
use Application\Domain\Model\Voyage;
use Application\Domain\Model\Cargo;
use Application\Infrastrucure\Persistence\Doctrine\CargoRepositoryDoctrine;
/**
 *  VoyageRepositoryDoctrineTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageRepositoryDoctrineTest extends TestCase
{
    /**
     * @var Voyage\VoyageRepositoryInterface
     */
    protected $voyageRepository;
    
    /**
     * @var Cargo\CargoRepositoryInterface
     */
    protected $cargoRepository;


    protected function setUp()
    {
        $this->createEntitySchema('Application\Domain\Model\Cargo\Cargo');
        $this->createEntitySchema('Application\Domain\Model\Voyage\Voyage');
        
        $this->voyageRepository = $this->getTestEntityManager()->getRepository('Application\Domain\Model\Voyage\Voyage');
        $this->cargoRepository = $this->getTestEntityManager()->getRepository('Application\Domain\Model\Cargo\Cargo');
    }
    
    public function testStoreAndFindVoyage()
    {
        $voyageNumber = new Voyage\VoyageNumber('SHIP123');
        
        $voyage = new Voyage\Voyage($voyageNumber);
        $voyage->setName('MyVoyage');
        $voyage->setCapacity(1);
        
        $cargo = new Cargo\Cargo(new Cargo\TrackingId('1234'));
        $cargo->setSize(12);
        
        $this->getTestEntityManager()->persist($cargo);
        
        $voyage->bookCargo($cargo);
        
        $this->voyageRepository->store($voyage);
        $this->cargoRepository->store($cargo);
        
        $checkVoyage = $this->voyageRepository->findVoyage($voyageNumber);
        
        $bookedCargos = $checkVoyage->getBookedCargos();
        
        $this->assertTrue($voyage->sameIdentityAs($checkVoyage));
        $this->assertEquals('MyVoyage', $checkVoyage->getName());
        $this->assertTrue($cargo->sameIdentityAs($bookedCargos[0]));
    }
}
