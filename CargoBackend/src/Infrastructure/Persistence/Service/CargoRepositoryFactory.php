<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.03.14 - 18:31
 */

namespace Codeliner\CargoBackend\Infrastructure\Persistence\Service;

use Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class CargoRepositoryFactory
 *
 * @package Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRepositoryFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return CargoRepositoryInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        return $em->getRepository('Codeliner\CargoBackend\Model\Cargo\Cargo');
    }
}