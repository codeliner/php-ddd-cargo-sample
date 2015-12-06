<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 8:29 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Infrastructure;

use Codeliner\CargoBackend\Infrastructure\Persistence\DoctrineCargoRepository;
use Codeliner\CargoBackend\Model\Cargo\Cargo;
use Interop\Container\ContainerInterface;

/**
 * Class DoctrineCargoRepositoryFactory
 *
 * @package Codeliner\CargoBackend\Container\Infrastructure
 */
final class DoctrineCargoRepositoryFactory
{
    public function __invoke(ContainerInterface $container): DoctrineCargoRepository
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        return $em->getRepository(Cargo::class);
    }
}
