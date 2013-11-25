<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Service;

use Application\Service\BookingService;
use Application\Service\Policy\TenPercentOverbookingPolicy;
use Application\Domain\Model\Voyage;
use Application\Domain\Model\Cargo;
use ApplicationTest\TestCase;
/**
 *  BookingServiceTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingServiceTest extends TestCase
{
    /**
     *
     * @var BookingService 
     */
    protected $bookingService;
    
    protected function setUp()
    {
        $this->createEntitySchema('Application\Domain\Model\Cargo\Cargo');
        $this->createEntitySchema('Application\Domain\Model\Voyage\Voyage');
        
        $this->bookingService = new BookingService();
        
        $this->bookingService->setCargoRepository(
            $this->getTestEntityManager()->getRepository('Application\Domain\Model\Cargo\Cargo')
        );
        
        $this->bookingService->setVoyageRepository(
            $this->getTestEntityManager()->getRepository('Application\Domain\Model\Voyage\Voyage')
        );
        
        $this->bookingService->setOverbookingPolicy(new TenPercentOverbookingPolicy());
    }
    
    public function testBookNewCargo()
    {
        $voyage = new Voyage\Voyage(new Voyage\VoyageNumber('123'));
        $voyage->setCapacity(100);
        $voyage->setName('Shipping');
        
        $cargo1 = new Cargo\Cargo(new Cargo\TrackingId('333'));
        $cargo1->setSize(50);
        
        $this->bookingService->bookNewCargo($cargo1, $voyage);
        
        $cargos = $voyage->getBookedCargos();
        
        $this->assertTrue(isset($cargos[0]));
        
        $this->assertTrue($cargo1->sameIdentityAs($cargos[0]));
    }
    
    /**
     * @expectedException Application\Service\Exception\ServiceException
     */
    public function testBookNewCargoFailing()
    {
        $voyage = new Voyage\Voyage(new Voyage\VoyageNumber('123'));
        $voyage->setCapacity(50);
        $voyage->setName('Shipping');
        
        $cargo1 = new Cargo\Cargo(new Cargo\TrackingId('333'));
        $cargo1->setSize(60);
        
        $this->bookingService->bookNewCargo($cargo1, $voyage);
    }
}
