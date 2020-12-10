<?php

declare(strict_types=1);

namespace SimpleAsFuck\LaravelOrm\Database\Laravel;

use Illuminate\Database\ConnectionInterface;

final class Transaction extends \SimpleAsFuck\Orm\Database\Abstracts\Transaction
{
    private ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function isActive(): bool
    {
        return $this->connection->transactionLevel() !== 0;
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }
}
