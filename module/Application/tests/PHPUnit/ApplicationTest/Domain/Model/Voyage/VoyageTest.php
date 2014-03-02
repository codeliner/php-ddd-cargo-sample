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
    }

    /**
     * @test
     */
    public function it_has_voyage_number()
    {
        $this->assertEquals('SHIP123', $this->voyage->getVoyageNumber()->toString());
    }

    /**
     * @test
     */
    public function it_is_same_as_other_voyage_with_same_voyage_number()
    {
        $voyageNumber = new Voyage\VoyageNumber('SHIP123');
        
        $checkVoyage = new Voyage\Voyage($voyageNumber);
        
        $this->assertTrue($this->voyage->sameIdentityAs($checkVoyage));
    }
}
