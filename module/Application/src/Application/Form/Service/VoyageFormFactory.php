<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Form\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Form\VoyageForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
/**
 * VoyageFormFactory
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $voyageHydrator = new DoctrineObject(
            $serviceLocator->get('doctrine.entitymanager.orm_default'), 
            'Application\Domain\Model\Voyage\Voyage'
        );
        
        $voyageForm = new VoyageForm();
        $voyageForm->setHydrator($voyageHydrator);
        
        return $voyageForm;
    }
}
