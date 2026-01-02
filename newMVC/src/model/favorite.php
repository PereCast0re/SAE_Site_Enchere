<?php

require_once('src/lib/database.php');

class FavoriteRepository
{
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function setProductFavorite($id_product, $id_user)
    {
        $pdo = $this->connection;
        $request = "INSERT INTO Interest(id_product, id_user) VALUES (:id_product, :id_user)";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([
            ':id_product' => $id_product,
            ':id_user' => $id_user
        ]);

        return $success;
    }

    function isProductFavorite($id_product, $id_user)
    {
        $pdo = $this->connection;
        $request = "SELECT COUNT(*) FROM interest WHERE id_product = :id_product AND id_user = :id_user";
        $temp = $pdo->prepare($request);
        $temp->execute([
            ':id_product' => $id_product,
            ':id_user' => $id_user
        ]);
        $success = $temp->fetchColumn();

        return $success > 0;
    }

    function unsetProductFavorite($id_product, $id_user)
    {
        $pdo = $this->connection;
        $request = "DELETE FROM Interest WHERE id_product = :id_product AND id_user = :id_user";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([
            ':id_product' => $id_product,
            ':id_user' => $id_user
        ]);

        return $success;
    }
}