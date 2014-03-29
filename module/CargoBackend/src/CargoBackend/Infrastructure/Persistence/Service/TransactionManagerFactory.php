<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 27.03.14 - 20:27
 */

namespace CargoBackend\Infrastructure\Persistence\Service;

use CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TransactionManagerFactory
 *
 * @package CargoBackend\Infrastructure\Persistence\Transaction
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TransactionManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TransactionManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new TransactionManager($serviceLocator->get('doctrine.entitymanager.orm_default'));
    }
}
 