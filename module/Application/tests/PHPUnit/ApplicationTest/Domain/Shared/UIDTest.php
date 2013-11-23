<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Shared;

use ApplicationTest\TestCase;
use Application\Domain\Shared\UID;
/**
 * TestCase for UID
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class UIDTest extends TestCase
{
    public function testToString()
    {
        $id = uniqid();
        
        $uid = new UID($id);
        
        $this->assertEquals($id, $uid->toString());
    }
    
    public function testGenerateNewUID()
    {
        $uid = new UID();
        $this->assertNotNull($uid->toString());
    }
    
    public function testSameValueAs()
    {
        $uid1 = new UID();
        $uid2 = new UID($uid1->toString());
        
        $this->assertTrue($uid1->sameValueAs($uid2));
        
        $uid3 = new UID();
        
        $this->assertFalse($uid1->sameValueAs($uid3));
    }
}
