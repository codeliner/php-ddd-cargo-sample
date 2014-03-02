<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Controller;

use Application\Service\RoutingService;
use Rhumsaa\Uuid\Uuid;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Domain\Model\Cargo;
use Application\Domain\Model\Voyage\VoyageRepositoryInterface;
use Application\Form\CargoForm;
/**
 * MVC Controller for Cargo Management
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoController extends AbstractActionController
{
    /**
     * The CargoRepository
     * 
     * @var Cargo\CargoRepositoryInterface 
     */
    protected $cargoRepository;

    /**
     *
     * @var CargoForm 
     */
    protected $cargoForm;

    /**
     * @var RoutingService
     */
    protected $routingService;

    /**
     * List of locations
     *
     * @var array
     */
    protected $locations;


    public function indexAction()
    {
        $cargos = $this->cargoRepository->getAll();
        
        return new ViewModel(array('cargos' => $cargos));
    }
    
    public function showAction()
    {
        $trackingId = $this->getEvent()->getRouteMatch()->getParam('trackingid');
        
        if (is_null($trackingId)) {
            throw new \InvalidArgumentException('Cargo can not be found. TrackingId missing!');
        }
        
        $trackingId = new Cargo\TrackingId(Uuid::fromString($trackingId));
        
        $cargo = $this->cargoRepository->get($trackingId);
        
        if (is_null($cargo)) {
            throw new \RuntimeException('Cargo can not be found. Please check the trackingId!');
        }
        
        return array('cargo' => $cargo);
    }
    
    public function addAction()
    {
        //we use the post redirect get pattern and redirect to same location
        $prg = $this->prg();
        
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // returned a response to redirect us
            return $prg;
        } elseif ($prg === false) {
            // this wasn't a POST request
            // probably this is the first time the form was loaded
            return array('form' => $this->cargoForm);
        }

        $this->cargoForm->setData($prg);
        
        if ($this->cargoForm->isValid()) {

            $routeSpecification = new Cargo\RouteSpecification(
                $this->cargoForm->get('origin')->getValue(),
                $this->cargoForm->get('destination')->getValue()
            );

            $newCargo = new Cargo\Cargo($this->cargoRepository->getNextTrackingId(), $routeSpecification);

            $this->cargoRepository->store($newCargo);
            
            return $this->redirect()->toRoute(
                'application/default/trackingid',
                array(
                    'controller' => 'cargo',
                    'action'     => 'suggest-itineraries',
                    'trackingid' => $newCargo->trackingId()->toString()
                )
            );
        } else {
            return array('form' => $this->cargoForm);
        }
    }

    public function suggestItinerariesAction()
    {
        $trackingId = $this->getEvent()->getRouteMatch()->getParam('trackingid');

        if (is_null($trackingId)) {
            throw new \InvalidArgumentException('Cargo can not be found. TrackingId missing!');
        }

        $trackingId = new Cargo\TrackingId(Uuid::fromString($trackingId));

        $cargo = $this->cargoRepository->get($trackingId);

        if (is_null($cargo)) {
            throw new \RuntimeException('Cargo can not be found. Please check the trackingId!');
        }

        $itineraries = $this->routingService->fetchRoutesForSpecification($cargo->routeSpecification());

        $itineraryData = array();

        foreach($itineraries as $itinerary) {

            $legs = array();

            foreach($itinerary->legs() as $leg) {
                $legs[] = array(
                    'loadLocation' => $this->locations[$leg->loadLocation()],
                    'unloadLocation' => $this->locations[$leg->unloadLocation()],
                    'loadTime'       => $leg->loadTime()->format('Y-m-d H:i'),
                    'unloadTime'     => $leg->unloadTime()->format('Y-m-d H:i')
                );
            }

            $itineraryData[] = array(
                'legs' => $legs
            );
        }

        return new ViewModel(array(
            'cargo' => array(
                'trackingId' => $cargo->trackingId()->toString(),
                'origin'     => $this->locations[$cargo->origin()]
            ),
            'routeSpecification' => array(
                'origin' => $this->locations[$cargo->routeSpecification()->origin()],
                'destination' => $this->locations[$cargo->routeSpecification()->destination()],
            ),
            'itineraries' => $itineraryData
        ));
    }

    public function assignItineraryAction()
    {
        $trackingId = $this->getEvent()->getRouteMatch()->getParam('trackingid');
        $itineraryIndex = $this->getEvent()->getRouteMatch()->getParam('index');

        if (is_null($trackingId)) {
            throw new \InvalidArgumentException('Cargo can not be found. TrackingId missing!');
        }

        $trackingId = new Cargo\TrackingId(Uuid::fromString($trackingId));

        $cargo = $this->cargoRepository->get($trackingId);

        if (is_null($cargo)) {
            throw new \RuntimeException('Cargo can not be found. Please check the trackingId!');
        }

        $itineraries = $this->routingService->fetchRoutesForSpecification($cargo->routeSpecification());

        if (!isset($itineraries[$itineraryIndex])) {
            throw new \RuntimeException('Cargo can not be assigned to route. Invalid route index provided!');
        }

        $cargo->assignToRoute($itineraries[$itineraryIndex]);

        $this->cargoRepository->store($cargo);

        return $this->redirect()->toRoute(
            'application/default/trackingid',
            array(
                'controller' => 'cargo',
                'action'     => 'show',
                'trackingid' => $cargo->trackingId()->toString()
            )
        );
    }
    
    /**
     * Set the CargoRepository
     * 
     * @param Cargo\CargoRepositoryInterface $aCargoRepository
     * @return void
     */
    public function setCargoRepository(Cargo\CargoRepositoryInterface $aCargoRepository)
    {
        $this->cargoRepository = $aCargoRepository;
    }
    
    /**
     * Set a cargo form.
     * 
     * @param CargoForm $aCargoForm
     * @return void
     */
    public function setCargoForm(CargoForm $aCargoForm)
    {
        $this->cargoForm = $aCargoForm;
    }

    /**
     * @param RoutingService $aRoutingService
     */
    public function setRoutingService(RoutingService $aRoutingService)
    {
        $this->routingService = $aRoutingService;
    }

    /**
     * @param array $aLocationList
     */
    public function setLocations(array $aLocationList)
    {
        $this->locations = $aLocationList;
    }
}
