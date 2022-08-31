<?php

namespace Ascron\Check24Task\Repository;

use Ascron\Check24Task\Database\DatabaseConnection;

class ArticleRepository implements RepositoryInterface
{
    private DatabaseConnection $connection;
    private $tableName = 'article';

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getList(int $limit, int $offset): array
    {
        return $this->connection->selectFromTable($this->tableName, [], ['id DESC'], $limit, $offset);
    }

    public function createArticle(string $imageUrl, string $title, int $author, string $text): void
    {
        $this->connection->insertIntoTable(
            $this->tableName,
            [
                'created_at' => date('Y-m-d H:i:s'),
                'image_url' => $imageUrl,
                'title' => $title,
                'author_id' => $author,
                'text' => $text,
            ]
        );
    }
}