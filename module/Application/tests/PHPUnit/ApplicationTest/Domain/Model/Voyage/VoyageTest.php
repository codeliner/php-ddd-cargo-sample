<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Voyage;

use ApplicationTest\TestCase;
use Application\Domain\Model\Voyage;
use Application\Domain\Model\Cargo;
/**
 *  VoyageTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageTest extends TestCase
{
    /**
     *
     * @var Voyage\Voyage 
     */
    protected $voyage;
    
    protected function setUp()
    {
        $voyageNumber = new Voyage\VoyageNumber("SHIP123");
        $this->voyage = new Voyage\Voyage($voyageNumber);
        $this->voyage->setName('HongkongToHamburg');
        $this->voyage->setCapacity(100);
    }
    
    public function testGetVoyageNumber()
    {
        $this->assertEquals('SHIP123', $this->voyage->getVoyageNumber()->toString());
    }
    
    public function testGetName() 
    {
        $this->assertEquals('HongkongToHamburg', $this->voyage->getName());
    }
    
    public function testGetCapacity()
    {
        $this->assertEquals(100, $this->voyage->getCapacity());
    }
    
    public function testBookCargo()
    {
        $cargo = new Cargo\Cargo(new Cargo\TrackingId('1234'));
        $this->voyage->bookCargo($cargo);
        
        $cargos = $this->voyage->getBookedCargos();
        
        $this->assertTrue($cargo->sameIdentityAs($cargos[0]));
    }
    
    public function testGetFreeCapacity()
    {
        $this->assertEquals($this->voyage->getCapacity(), $this->voyage->getFreeCapacity());
        
        $cargo = new Cargo\Cargo(new Cargo\TrackingId('1234'));
        $cargo->setSize(10);
        $this->voyage->bookCargo($cargo);
        
        $this->assertEquals(90, $this->voyage->getFreeCapacity());
    }
    
    public function testSameIdentityAs()
    {
        $voyageNumber = new Voyage\VoyageNumber('SHIP123');
        
        $checkVoyage = new Voyage\Voyage($voyageNumber);
        
        $this->assertTrue($this->voyage->sameIdentityAs($checkVoyage));
    }
}
