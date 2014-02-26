<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Cargo;

use Application\Domain\Model\Cargo\Itinerary;
use ApplicationTest\TestCase;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Domain\Model\Cargo\Leg;
/**
 * Class ItineraryTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ItineraryTest extends TestCase
{
    public function testLegs()
    {
        $legs = [new Leg('Hongkong', 'Hamburg'), new Leg('Hamburg', 'New York')];

        $itinerary = new Itinerary($legs);
        
        $this->assertSame($legs, $itinerary->legs());
    }
    
    public function testSameValueAs()
    {
        $legs = [new Leg('Hongkong', 'Hamburg'), new Leg('Hamburg', 'New York')];

        $itinerary = new Itinerary($legs);
        $sameItinerary = new Itinerary($legs);
        
        $otherLegs = [new Leg('New York', 'Melbourne'), new Leg('Melbourne', 'Rotterdam')];

        $otherItinerary = new Itinerary($otherLegs);
        
        $this->assertTrue($itinerary->sameValueAs($sameItinerary));
        $this->assertFalse($itinerary->sameValueAs($otherItinerary));
    }
}
