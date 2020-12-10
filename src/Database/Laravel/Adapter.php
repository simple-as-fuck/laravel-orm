<?php

declare(strict_types=1);

namespace SimpleAsFuck\LaravelOrm\Database\Laravel;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\DatabaseManager;
use SimpleAsFuck\Orm\Database\Abstracts\Connection;
use SimpleAsFuck\Orm\Database\Abstracts\Query;

final class Adapter extends Connection
{
    private \Illuminate\Database\Connection $connection;

    public function __construct(DatabaseManager $databaseManager, Repository $config)
    {
        parent::__construct();

        $this->connection = $databaseManager->connection($config->get('orm.database-connection'));
    }

    public function prepare(string $statement): Query
    {
        return new \SimpleAsFuck\Orm\Database\Pdo\Query(
            $this->connection->getPdo(),
            $this->connection->getPdo()->prepare($statement)
        );
    }

    protected function createTransaction(): Transaction
    {
        $this->connection->beginTransaction();
        return new Transaction($this->connection);
    }
}
