<?php

require_once('src/lib/database.php');

class Comment
{
    public int $id_product;
    public int $id_user;
    public string $comment;
    public string $comment_date;
    public string $full_name;
}

class CommentRepository
{
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function getCommentsFromProduct($id_product)
    {
        $pdo = $this->connection;
        $request = "SELECT CONCAT(u.firstname, ' ', u.name) AS full_name, c.comment, c.comment_date, c.id_user FROM Comment c JOIN Users u ON u.id_user = c.id_user WHERE id_product = :id_product ORDER BY comment_date DESC";
        $temp = $pdo->prepare($request);
        $temp->execute([
            "id_product" => $id_product
        ]);

        $comments = [];
        while (($row = $temp->fetch())) {
            $comment = new Comment();
            $comment->full_name = $row['full_name'];
            $comment->comment = $row['comment'];
            $comment->comment_date = $row['comment_date'];
            $comment->id_user = $row['id_user'];
            $comments[] = $comment;
        }

        return $comments;
    }

    function addCommentToProduct($id_product, $id_user, $comment)
    {
        $pdo = $this->connection;
        $request = "INSERT INTO Comment VALUES (:id_product, :id_user, :comment, NOW())";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([
            "id_product" => $id_product,
            "id_user" => $id_user,
            "comment" => $comment
        ]);

        return $success;
    }
}