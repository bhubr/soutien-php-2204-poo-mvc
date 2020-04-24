<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class PostManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'post';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $post
     * @return int
     */
    public function insert(array $post): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`, `slug`, `content`) VALUES (:title, :slug, :content)");
        $statement->bindValue('title', $post['title'], \PDO::PARAM_STR);
        $statement->bindValue('slug', $post['slug'], \PDO::PARAM_STR);
        $statement->bindValue('content', $post['content'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }


    public function selectOneBySlug(string $slug)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE slug=:slug");
        $statement->bindValue('slug', $slug, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
