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
use Zend\Validator\Callback;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Digits;
/**
 * Form class to manage add and update of a Cargo.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoForm extends Form
{
    /**
     * List of possible locations
     *
     * @var array
     */
    private $locations = array();

    /**
     * @param array $aLocationList
     * @param array $anOptionList
     */
    public function __construct(array $aLocationList, $anOptionList = array())
    {
        parent::__construct('CargoForm', $anOptionList);

        $this->locations = $aLocationList;
        
        $this->add(array(
            'name' => 'origin',
            'options' => array(
                'label' => 'Origin',
                'value_options' => $this->locations,
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
            'type'  => 'Select',
            
        ));

        $this->add(array(
            'name' => 'final_destination',
            'options' => array(
                'label' => 'Destination',
                'value_options' => $this->locations,
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
            'type'  => 'Select',

        ));
        
        $this->add(array(
            'name' => 'trackingId',
            'type'  => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => array(
                'value' => 'assign to itinerary',
                'class' => 'btn btn-success'
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if (is_null($this->filter)) {
            $trackingIdValidator = new StringLength(36);
            $regexValidator = new Regex('/^[a-zA-Z0-9_-]+$/');

            $trackingIdInput = new Input('trackingId');
            $trackingIdInput->allowEmpty();
            $trackingIdInput->setRequired(false);
            $trackingIdInput->getValidatorChain()
                ->attach($trackingIdValidator)
                ->attach($regexValidator);

            $inArrayValidator = new InArray();
            $inArrayValidator->setHaystack(array_keys($this->locations));

            $originInput = new Input('origin');
            $originInput->getValidatorChain()->attach($inArrayValidator);


            $notSameValidator = new Callback(array(
                'callback' => function($value, $context = null) {
                        if ($context) {
                            return $value !== $context['origin'];
                        }

                        return true;
                    },
                'messages' => array(
                    Callback::INVALID_VALUE => 'Origin and Destination are the same'
                )
            ));

            $destinationInput = new Input('final_destination');
            $destinationInput->getValidatorChain()
                ->attach($inArrayValidator)
                ->attach($notSameValidator);

            $filter = new InputFilter();
            $filter->add($trackingIdInput)->add($originInput)->add($destinationInput);
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
}
