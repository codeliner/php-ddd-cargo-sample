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
 * Form class to manage add and update of a Cargo.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('CargoForm', $options);
        
        $this->add(array(
            'name' => 'size',
            'options' => array(
                'label' => 'Cargo Size',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
            'type'  => 'Text',
            
        ));
        
        $this->add(array(
            'name' => 'trackingId',
            'type'  => 'Hidden',
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
            $sizeValidator = new Digits();
            $sizeInput = new Input('size');
            $sizeInput->setRequired(true);
            $sizeInput->getValidatorChain()
                ->addValidator($sizeValidator);

            $trackingIdValidator = new StringLength(13);
            $trackingIdInput = new Input('trackingId');
            $trackingIdInput->allowEmpty();
            $trackingIdInput->setRequired(false);
            $trackingIdInput->getValidatorChain()
                ->addValidator($trackingIdValidator);

            $filter = new InputFilter();
            $filter->add($sizeInput)->add($trackingIdInput);
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
}
