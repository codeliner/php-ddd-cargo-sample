<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Controller;

use Application\Domain\Model\Voyage;
use Application\Form\VoyageForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
/**
 * MVC Controller for Voyage management
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageController extends AbstractActionController 
{
    /**
     *
     * @var Voyage\VoyageRepositoryInterface 
     */
    protected $voyageRepository;
    
    /**
     *
     * @var VoyageForm 
     */
    protected $voyageForm;


    public function indexAction()
    {
        return array('voyages' => $this->voyageRepository->findAll());
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
            return array('form' => $this->voyageForm);
        }
        
        $this->voyageForm->setData($prg);
        
        if ($this->voyageForm->isValid()) {
            $voyageNumber = new Voyage\VoyageNumber($prg['voyage_number']);
            $newVoyage = new Voyage\Voyage($voyageNumber);            
            
            $this->voyageForm->bind($newVoyage);            
            $this->voyageForm->bindValues();           
            $this->voyageRepository->store($newVoyage);
            
            return $this->redirect()->toRoute(
                'application/default', 
                array(
                    'controller' => 'voyage',
                    'action'     => 'index'
                )
            );
        } else {
            return array('form' => $this->voyageForm);
        }
    }
    
    public function showAction()
    {
        $voyageNumber = $this->getEvent()->getRouteMatch()->getParam('voyagenumber', '');
        
        $voyage = $this->voyageRepository->findVoyage(new Voyage\VoyageNumber($voyageNumber));
        
        if(is_null($voyage)) {
            throw new \Exception('Voyage could not be found');
        }
        
        return array('voyage' => $voyage);
    }
    
    public function setVoyageRepository(Voyage\VoyageRepositoryInterface $voyageRepository)
    {
        $this->voyageRepository = $voyageRepository;
    }

    public function setVoyageForm(VoyageForm $voyageForm)
    {
        $this->voyageForm = $voyageForm;
    }
}
