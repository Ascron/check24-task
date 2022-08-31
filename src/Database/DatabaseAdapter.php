<?php declare(strict_types=1);

namespace Ascron\Check24Task\Database;

interface DatabaseAdapter
{
    public function getConnection(): DatabaseConnection;

    public function selectFromTable(
        string $table,
        array $where = [],
        array $orderBy = [],
        int $limit = 0,
        int $offset = 0
    ): array;

    public function insertIntoTable(string $table, array $data): bool;

    public function updateTable(string $table, array $data, array $where = []): int;

    public function deleteFromTable(string $table, array $where = []): int;

    public function getRowCount(string $table): int;
}