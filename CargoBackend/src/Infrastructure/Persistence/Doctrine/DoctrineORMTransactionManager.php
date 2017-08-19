<?php
declare(strict_types=1);

namespace Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine;

use Codeliner\CargoBackend\Application\TransactionManager;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineORMTransactionManager implements TransactionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DoctrineORMTransactionManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function begin()
    {
        $this->entityManager->beginTransaction();
    }

    public function commit()
    {
        $this->entityManager->commit();
    }

    public function rollback()
    {
        $this->entityManager->rollback();
    }
}
