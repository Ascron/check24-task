<?php

namespace Ascron\Check24Task\Database;

class DatabaseConnection
{
    public function __construct(
        private DatabaseAdapter $adapter,
    )
    {}

    public function selectFromTable(string $table, array $where = [], array $orderBy = [], int $limit = 0, int $offset = 0): array
    {
        return $this->adapter->selectFromTable($table, $where, $orderBy, $limit, $offset);
    }

    public function insertIntoTable(string $table, array $data): void
    {
        $this->adapter->insertIntoTable($table, $data);
    }


}