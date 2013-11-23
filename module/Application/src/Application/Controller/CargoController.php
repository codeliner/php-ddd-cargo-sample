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
use Application\Domain\Model\Cargo;
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


    public function indexAction()
    {
        $cargos = $this->cargoRepository->findAll();
        
        return new ViewModel(array('cargos' => $cargos));
    }
    
    public function showAction()
    {
        $trackingId = $this->getEvent()->getRouteMatch()->getParam('trackingid');
        
        if (is_null($trackingId)) {
            throw new \InvalidArgumentException('Cargo can not be found. TrackingId missing!');
        }
        
        $trackingId = new Cargo\TrackingId($trackingId);
        
        $cargo = $this->cargoRepository->findCargo($trackingId);
        
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
        
        $newCargo = new Cargo\Cargo($this->cargoRepository->getNextTrackingId());
        $this->cargoForm->bind($newCargo);
        $this->cargoForm->setData($prg);
        
        if ($this->cargoForm->isValid()) {
            $this->cargoRepository->store($newCargo);
            
            return $this->redirect()->toRoute(
                'application/default', 
                array(
                    'controller' => 'cargo',
                    'action'     => 'index'
                )
            );
        } else {
            return array('form' => $this->cargoForm);
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
     * Set a cargo form.
     * 
     * @param CargoForm $cargoForm
     * @return void
     */
    public function setCargoForm(CargoForm $cargoForm)
    {
        $this->cargoForm = $cargoForm;
    }
}
