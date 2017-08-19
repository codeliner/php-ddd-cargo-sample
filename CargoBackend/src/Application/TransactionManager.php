<?php
declare(strict_types=1);

namespace Codeliner\CargoBackend\Application;

interface TransactionManager
{
    /**
     * Begin transaction
     */
    public function begin();

    /**
     * Commit transaction
     */
    public function commit();

    /**
     * Rollback transaction
     */
    public function rollback();
}
