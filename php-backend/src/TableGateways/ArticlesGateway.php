<?php

namespace Src\TableGateways;

class ArticlesGateway
{
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT
                id, title, content, created_at
            FROM
                articles
            ORDER BY created_at DESC;
        ";
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT
                id, title, content, created_at
            FROM
                articles
            WHERE id = ?;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO articles
                (title, content)
            VALUES
                (:title, :content);
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'title'   => $input['title'],
                'content' => $input['content'] ?? '',
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "
            UPDATE articles
            SET
                title   = :title,
                content = :content
            WHERE id = :id;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'id'      => (int) $id,
                'title'   => $input['title'],
                'content' => $input['content'] ?? '',
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM articles
            WHERE id = :id;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}