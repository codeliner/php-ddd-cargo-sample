<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Service\Policy;

use Application\Service\Policy\TenPercentOverbookingPolicy;
use Application\Domain\Model\Cargo;
use Application\Domain\Model\Voyage;
use ApplicationTest\TestCase;
/**
 *  TenPercentOverbookingPolicyTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TenPercentOverbookingPolicyTest extends TestCase
{
    public function testIsAllowed()
    {
        $overbookingPolicy = new TenPercentOverbookingPolicy();
        
        $voyage = new Voyage\Voyage(new Voyage\VoyageNumber('123'));
        $voyage->setCapacity(100);
        
        $cargo1 = new Cargo\Cargo(new Cargo\TrackingId('333'));
        $cargo1->setSize(50);
        
        $this->assertTrue($overbookingPolicy->isAllowed($cargo1, $voyage));
        
        $voyage->bookCargo($cargo1);
        
        $cargo2 = new Cargo\Cargo(new Cargo\TrackingId('334'));
        //overbooking limit: 50 + 60 = 100 * 1.1
        $cargo2->setSize(60);
        
        $this->assertTrue($overbookingPolicy->isAllowed($cargo2, $voyage));
        
        $voyage->bookCargo($cargo2);
        
        $cargo3 = new Cargo\Cargo(new Cargo\TrackingId('334'));
        //Voyage is charged off, booking of anathoer Cargo is not possible
        $cargo3->setSize(1);
        
        $this->assertFalse($overbookingPolicy->isAllowed($cargo3, $voyage));
    }
}
