<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 27.03.14 - 20:27
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Infrastructure;

use Codeliner\CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager;
use Interop\Container\ContainerInterface;

/**
 * Class TransactionManagerFactory
 *
 * @package Codeliner\CargoBackend\Infrastructure\Persistence\Transaction
 * @author Alexander Miertsch <contact@prooph.de>
 */
final class TransactionManagerFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return TransactionManager
     */
    public function __invoke(ContainerInterface $container): TransactionManager
    {
        return new TransactionManager($container->get('doctrine.entitymanager.orm_default'));
    }
}
