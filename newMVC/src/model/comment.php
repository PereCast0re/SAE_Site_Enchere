<?php

require_once('src/lib/database.php');

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

        return $temp->fetchAll(PDO::FETCH_ASSOC);
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