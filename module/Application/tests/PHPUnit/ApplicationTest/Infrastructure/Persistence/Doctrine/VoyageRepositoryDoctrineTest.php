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
    
    protected function setUp()
    {
        $this->createEntitySchema('Application\Domain\Model\Voyage\Voyage');
        
        $this->voyageRepository = $this->getTestEntityManager()->getRepository('Application\Domain\Model\Voyage\Voyage');
    }
    
    public function testStoreAndFindVoyage()
    {
        $voyageNumber = new Voyage\VoyageNumber('SHIP123');
        
        $voyage = new Voyage\Voyage($voyageNumber);
        $voyage->setName('MyVoyage');
        $voyage->setCapacity(1);
        
        $this->voyageRepository->store($voyage);
        
        $checkVoyage = $this->voyageRepository->findVoyage($voyageNumber);
        
        $this->assertTrue($voyage->sameIdentityAs($checkVoyage));
        $this->assertEquals('MyVoyage', $checkVoyage->getName());
    }
}
