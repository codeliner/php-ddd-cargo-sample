<?php
declare(strict_types=1);

namespace Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine;

use Codeliner\CargoBackend\Application\TransactionManager;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineORMTransactionManager implements TransactionManager
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

    public function begin(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}
