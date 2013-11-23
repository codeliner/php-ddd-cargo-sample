<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Digits;
/**
 *  VoyageForm
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('VoyageForm', $options);
        
        $this->add(array(
            'name' => 'voyageNumber',
            'options' => array(
                'label' => 'Number',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
            'type'  => 'Text',
            
        ));
        
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
            'type'  => 'Text',
            
        ));
        
        $this->add(array(
            'name' => 'capacity',
            'options' => array(
                'label' => 'Capacity',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
            'type'  => 'Text',
            
        ));
        
        $this->add(array(
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => array(
                'value' => 'Submit',
                'class' => 'btn btn-success'
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if (is_null($this->filter)) {
            $voyageNumberLengthValidator = new StringLength(30);
            $voyageNumberInput = new Input('voyage_number');
            $voyageNumberInput->setRequired(true)
                ->getValidatorChain()
                ->addValidator($voyageNumberLengthValidator);
            
            $nameLengthValidator = new StringLength(100);
            $nameInput = new Input('name');
            $nameInput->setRequired(true);
            $nameInput->getValidatorChain()
                ->addValidator($nameLengthValidator);

            $digitsValidator = new Digits();
            $capacityInput = new Input('capacity');
            $capacityInput->setRequired(true);
            $capacityInput->getValidatorChain()
                ->addValidator($digitsValidator);
            
            

            $filter = new InputFilter();
            $filter->add($voyageNumberInput)->add($nameInput)->add($capacityInput);
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
}
