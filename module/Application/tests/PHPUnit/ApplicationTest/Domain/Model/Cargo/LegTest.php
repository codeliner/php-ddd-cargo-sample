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
use Application\Domain\Model\Voyage\Voyage;
use Application\Domain\Model\Voyage\VoyageNumber;
use ApplicationTest\TestCase;

/**
 * Class LegTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class LegTest extends TestCase
{
    /**
     * @var Leg
     */
    private $leg;

    /**
     * @var Voyage
     */
    private $voyage;

    public function setUp()
    {
        $this->voyage = new Voyage(new VoyageNumber('SHIP123'));

        $this->leg = new Leg(
            $this->voyage,
            'Hongkong',
            'Hamburg',
            new \DateTime('2014-01-20 10:00:00'),
            new \DateTime('2014-02-02 18:00:00')
        );
    }

    /**
     * @test
     */
    public function it_has_a_referenced_voyage()
    {
        $this->assertTrue($this->voyage->sameIdentityAs($this->leg->voyage()));
    }

    /**
     * @test
     */
    public function it_has_a_load_location()
    {
        $this->assertEquals('Hongkong', $this->leg->loadLocation());
    }

    /**
     * @test
     */
    public function it_has_an_unload_location()
    {
        $this->assertEquals('Hamburg', $this->leg->unloadLocation());
    }

    /**
     * @test
     */
    public function it_is_same_value_as_leg_with_same_properties()
    {
        $sameLeg = new Leg(
            $this->voyage,
            'Hongkong',
            'Hamburg',
            new \DateTime('2014-01-20 10:00:00'),
            new \DateTime('2014-02-02 18:00:00')
        );

        $this->assertTrue($this->leg->sameValueAs($sameLeg));
    }

    /**
     * @test
     */
    public function it_is_not_same_value_as_leg_with_different_voyage()
    {
        $otherLeg = new Leg(
            new Voyage(new VoyageNumber('SHIP003')),
            'Hongkong',
            'Hamburg',
            new \DateTime('2014-01-20 10:00:00'),
            new \DateTime('2014-02-02 18:00:00')
        );

        $this->assertFalse($this->leg->sameValueAs($otherLeg));
    }
}
