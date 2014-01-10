<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Cargo;

use Application\Domain\Model\Cargo\Leg;
use ApplicationTest\TestCase;
/**
 * Class LegTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class LegTest extends TestCase
{
    public function testLoadLocation()
    {
        $leg = new Leg('Hongkong', 'Hamburg');
        
        $this->assertEquals('Hongkong', $leg->loadLocation());
    }
    
    public function testUnloadLocation()
    {
        $leg = new Leg('Hongkong', 'Hamburg');
        
        $this->assertEquals('Hamburg', $leg->unloadLocation());
    }
    
    public function testSameValueAs()
    {
        $leg = new Leg('Hongkong', 'Hamburg');
        $sameLeg = new Leg('Hongkong', 'Hamburg');
        $otherLeg = new Leg('Hongkong', 'New York');
        
        $this->assertTrue($leg->sameValueAs($sameLeg));
        $this->assertFalse($leg->sameValueAs($otherLeg));
    }
}
