<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodelinerTest\CargoBackend\Domain\Model\Cargo;

use CodelinerTest\CargoBackend\TestCase;
use Codeliner\CargoBackend\Model\Cargo\RouteSpecification;
/**
 *  RouteSpecificationTest
 * 
 * @author Alexander Miertsch <contact@prooph.de>
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
        $this->object = new RouteSpecification('Hongkong', 'Berlin');
    }

    /**
     * @test
     */
    public function it_has_an_origin()
    {
        $this->assertEquals('Hongkong', $this->object->origin());
    }

    /**
     * @test
     */
    public function it_has_a_destination()
    {
        $this->assertEquals('Berlin', $this->object->destination());
    }

    /**
     * @test
     */
    public function it_is_same_value_as_route_specification_with_same_properties()
    {
        $validCheck = new RouteSpecification('Hongkong', 'Berlin');
        
        $this->assertTrue($this->object->sameValueAs($validCheck));
    }

    /**
     * @test
     */
    public function it_is_not_same_value_as_route_specification_with_different_origin()
    {
        $invalidCheck = new RouteSpecification('New York', 'Berlin');

        $this->assertFalse($this->object->sameValueAs($invalidCheck));
    }

    /**
     * @test
     */
    public function it_is_not_same_value_as_route_specification_with_different_destination()
    {
        $invalidCheck = new RouteSpecification('Hongkong', 'New York');

        $this->assertFalse($this->object->sameValueAs($invalidCheck));
    }
}
