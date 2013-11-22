<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Cargo;

use ApplicationTest\TestCase;
use Application\Domain\Model\Cargo\Cargo;
use Application\Domain\Shared\UID;
/**
 *  CargoTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoTest extends TestCase
{
    public function testSameIdentityAs()
    {
        $uid = new UID();
        $cargo1 = new Cargo($uid);
        $cargo2 = new Cargo($uid);
        
        $this->assertTrue($cargo1->sameIdentityAs($cargo2));
        
        $uid2 = new UID();
        
        $cargo3 = new Cargo($uid2);
        
        $this->assertFalse($cargo1->sameIdentityAs($cargo3));
    }
}
