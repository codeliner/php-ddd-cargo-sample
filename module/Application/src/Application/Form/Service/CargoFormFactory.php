<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Form\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\CargoForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
/**
 *  CargoFormFactory
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cargoForm = new CargoForm($serviceLocator->get('config')['locations']);
        
        return $cargoForm;
    }
}
