<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 27.03.14 - 20:22
 */

namespace Codeliner\CargoBackend\Infrastructure\Persistence\Transaction;
use Doctrine\ORM\EntityManager;

/**
 * Class TransactionManager
 *
 * @package Codeliner\CargoBackend\Infrastructure\Persistence\Transaction
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TransactionManager 
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $anEntityManager
     */
    public function __construct(EntityManager $anEntityManager)
    {
        $this->entityManager = $anEntityManager;
    }

    /**
     * @return void
     */
    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * @return void
     */
    public function commit()
    {
        $this->entityManager->commit();
    }

    /**
     * @return void
     */
    public function rollback()
    {
        $this->entityManager->rollback();
    }
}
 