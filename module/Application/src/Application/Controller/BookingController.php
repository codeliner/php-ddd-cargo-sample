<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Application\Domain\Model\Cargo;
use Application\Domain\Model\Voyage; 
use Application\Service\BookingService;
use Application\Service\Exception\ServiceException;
use Application\Service\Exception\RuntimeException;
/**
 * MVC Controller that manages the booking process of Voyage.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingController extends AbstractActionController
{
    /**
     * The CargoRepository
     * 
     * @var Cargo\CargoRepositoryInterface 
     */
    protected $cargoRepository;    
    
    /**
     *
     * @var Voyage\VoyageRepositoryInterface 
     */
    protected $voyageRepository;
    
    /**
     *
     * @var BookingService
     */
    protected $bookingService;

    /**
     * Book a Cargo on a Voyage
     */
    public function bookingAction()
    {
        //we use the post redirect get pattern and redirect to same location
        $prg = $this->prg();
        
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // returned a response to redirect us
            return $prg;
        } elseif ($prg === false) {
            throw new RuntimeException('Request is out of date.');
        }
        
        try {
            $trackingId = $prg['tracking_id'];
            
            if (empty($trackingId)) {
                throw new RuntimeException('TrackingId must not be empty');
            }
            
            $strLengthVal = new StringLength(1, 13);
            $regexVal = new Regex('/^[a-zA-Z0-9_-]+$/');
            
            if (!$strLengthVal->isValid($trackingId) || !$regexVal->isValid($trackingId)) {
                throw new RuntimeException('TrackingId is invalid');
            }
            
            $voyageNumber = $prg['voyage_number'];
            
            if (empty($voyageNumber)) {
                throw new RuntimeException('VoyageNumber must not be empty');
            }
            
            $strLengthVal = new StringLength(3, 30);
            $regexVal = new Regex('/^[a-zA-Z0-9_-]+$/');
            
            if (!$strLengthVal->isValid($voyageNumber) || !$regexVal->isValid($voyageNumber)) {
                throw new RuntimeException('VoyageNumber is invalid');
            }
            
            $cargo = $this->cargoRepository->findCargo(new Cargo\TrackingId($trackingId));
            
            if (is_null($cargo)) {
                throw new RuntimeException('Cargo can not be found');
            }
            
            $voyage = $this->voyageRepository->findVoyage(new Voyage\VoyageNumber($voyageNumber));
            
            if (is_null($voyage)) {
                throw new RuntimeException('Voyage can not be found');
            }
            
            $this->bookingService->bookNewCargo($cargo, $voyage);
            
            return array('msg' => 'Cargo was successfully booked', 'success' => true);
            
        } catch (ServiceException $ex) {
            return array('msg' => $ex->getMessage(), 'success' => false);
        }
    }
    
    /**
     * Set the CargoRepository
     * 
     * @param Cargo\CargoRepositoryInterface $cargoRepository
     * @return void
     */
    public function setCargoRepository(Cargo\CargoRepositoryInterface $cargoRepository) 
    {
        $this->cargoRepository = $cargoRepository;
    }
    
    /**
     * Set the voyage repository
     * 
     * @param Voyage\VoyageRepositoryInterface $voyageRepository
     * @return void
     */
    public function setVoyageRepository(Voyage\VoyageRepositoryInterface $voyageRepository)
    {
        $this->voyageRepository = $voyageRepository;
    }
    
    /**
     * Set BookingService
     * 
     * @param BookingService $bookingService
     * @return void
     */
    public function setBookingService(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
}
