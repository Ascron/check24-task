<?php declare(strict_types=1);

namespace Ascron\Check24Task\Database\Adapters;

use Ascron\Check24Task\Database\DatabaseAdapter;
use Ascron\Check24Task\Database\DatabaseConnection;

class MysqlAdapter implements DatabaseAdapter
{
    private \PDO $pdo;

    public function connect(): void
    {
        $this->pdo = new \PDO(
            $this->getConnectionLink(),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            [\PDO::ATTR_PERSISTENT => true]
        );
    }

    private function getConnectionLink(): string
    {
        return "mysql:host=mysql;dbname={$_ENV['MYSQL_DATABASE']}";
    }

    public function getConnection(): DatabaseConnection
    {
        return new DatabaseConnection($this);
    }

    public function selectFromTable(string $table, array $where = [], array $orderBy = [], int $limit = 0, int $offset = 0): array
    {
        $query = $this->buildSelectQuery($where, $orderBy, $limit, $offset);
        $bindings = $this->buildSelectBindings($table, $where, $orderBy, $limit, $offset);

        $statement = $this->pdo->prepare($query);
        $statement->execute($bindings);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function buildSelectQuery(array $where = [], array $orderBy = [], int $limit = 0, int $offset = 0): string
    {
        $query = "SELECT * FROM `?`";
        if (!empty($where)) {
            $wherePlaceholders = array_fill(0, count($where), '? = ?');
            $query .= " WHERE " . implode(' AND ', $wherePlaceholders);
        }
        if (!empty($orderBy)) {
            $orderByPlaceholders = array_fill(0, count($orderBy), '?');
            $query .= " ORDER BY " . implode(', ', $orderByPlaceholders);
        }
        if ($limit > 0) {
            $query .= " LIMIT ?";
        }
        if ($offset > 0) {
            $query .= " OFFSET ?";
        }
        return $query;
    }

    private function buildSelectBindings(
        string $table,
        array $where = [],
        array $orderBy = [],
        int $limit = 0,
        int $offset = 0
    ): array
    {
        $bindings = [$table];
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $bindings[] = $key;
                $bindings[] = $value;
            }
        }
        if (!empty($orderBy)) {
            foreach ($bindings as $key => $value) {
                $bindings[] = $key;
                $bindings[] = $value;
            }
        }
        if ($limit > 0) {
            $bindings[] = $limit;
        }
        if ($offset > 0) {
            $bindings[] = $offset;
        }
        return $bindings;
    }

    public function insertIntoTable(string $table, array $data): bool
    {
        $query = $this->buildInsertQuery($data);
        $bindings = $this->buildInsertBindings($table, $data);

        $statement = $this->pdo->prepare($query);
        return $statement->execute($bindings);
    }

    private function buildInsertQuery(array $data): string
    {
        $dataPlaceholders = array_fill(0, count($data), '?');
        return "INSERT INTO `?` VALUES (" . implode(', ', $dataPlaceholders) . ')';
    }

    private function buildInsertBindings(string $table, array $data): array
    {
        return array_merge([$table], $data);
    }

    public function updateTable(string $table, array $data, array $where = []): int
    {
        $query = $this->buildUpdateQuery($data, $where);
        $bindings = $this->buildUpdateBindings($table, $data, $where);

        $statement = $this->pdo->prepare($query);
        $statement->execute($bindings);
        return $statement->rowCount();
    }

    private function buildUpdateQuery(array $data, array $where): string
    {
        $dataPlaceholders = array_fill(0, count($data), '? = ?');
        $wherePlaceholders = array_fill(0, count($where), '? = ?');
        return "UPDATE `?` SET " . implode(', ', $dataPlaceholders) . " WHERE " . implode(' AND ', $wherePlaceholders);
    }

    private function buildUpdateBindings(string $table, array $data, array $where): array
    {
        $flatData = [];
        foreach ($data as $key => $value) {
            $flatData[] = $key;
            $flatData[] = $value;
        }

        return array_merge([$table], $flatData, $where);
    }

    public function deleteFromTable(string $table, array $where = []): int
    {
        $query = $this->buildDeleteQuery($where);
        $bindings = $this->buildDeleteBindings($table, $where);

        $statement = $this->pdo->prepare($query);
        $statement->execute($bindings);
        return $statement->rowCount();
    }

    private function buildDeleteQuery(array $where): string
    {
        $wherePlaceholders = array_fill(0, count($where), '? = ?');
        return "DELETE FROM `?` WHERE " . implode(' AND ', $wherePlaceholders);
    }

    private function buildDeleteBindings(string $table, array $where): array
    {
        return array_merge([$table], $where);
    }

    public function getRowCount(string $table): int
    {
        $statement = $this->pdo->prepare("SELECT COUNT(*) as `count` FROM `?`");
        $statement->execute([$table]);
        return (int)$statement->fetchColumn();
    }

}