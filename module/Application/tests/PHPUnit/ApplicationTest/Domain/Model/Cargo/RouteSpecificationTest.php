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
use Application\Domain\Model\Cargo\RouteSpecification;
/**
 *  RouteSpecificationTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteSpecificationTest extends TestCase
{
    /**
     *
     * @var RouteSpecification
     */
    protected $object;
    
    protected function setUp()
    {
        $this->object = new RouteSpecification('Hongkong', 'Berlin', 'Hamburg');
    }
    
    public function testGetOrigin()
    {
        $this->assertEquals('Hongkong', $this->object->getOrigin());
    }
    
    public function testGetDestination()
    {
        $this->assertEquals('Berlin', $this->object->getDestination());
    }
    
    public function testGetCustomsClearancePoint()
    {
        $this->assertEquals('Hamburg', $this->object->getCustomsClearancePoint());
    }
    
    public function testSameValueAs()
    {
        $validCheck = new RouteSpecification('Hongkong', 'Berlin', 'Hamburg');
        
        $this->assertTrue($this->object->sameValueAs($validCheck));
        
        $invalidCheck = new RouteSpecification('New York', 'Berlin', 'Hamburg');
        
        $this->assertFalse($this->object->sameValueAs($invalidCheck));
    }
}
