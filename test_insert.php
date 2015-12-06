<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 9:29 PM
 */

require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var \Codeliner\CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager $transactionManager */
$transactionManager = $container->get(\Codeliner\CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager::class);

$transactionManager->beginTransaction();

/** @var \Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface $cargoRepository */
$cargoRepository = $container->get(\Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface::class);

try {
    $cargo = new \Codeliner\CargoBackend\Model\Cargo\Cargo(
        \Codeliner\CargoBackend\Model\Cargo\TrackingId::generate(),
        new \Codeliner\CargoBackend\Model\Cargo\RouteSpecification('DEHAM', 'USNYC')
    );

    $cargoRepository->store($cargo);

    $transactionManager->commit();

} catch (\Exception $e) {
    $transactionManager->rollback();

    throw $e;
}