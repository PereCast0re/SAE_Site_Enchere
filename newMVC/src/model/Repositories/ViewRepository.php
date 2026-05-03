<?php

namespace App\Model\Repositories;

use PDO;

class ViewRepository {
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function getViewProduct($id_annoncement, $current_date)
    {
        $pdo = $this->connection;
        $requete = "SELECT * from productview where id_product = :id_product and view_date = :current_date";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_product" => $id_annoncement,
            "current_date" => $current_date
        ]);

        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function InsertNewView($id_annoncement, $current_date)
    {
        $pdo = $this->connection;
        $requete = "INSERT into productview (id_product, id_user, view_number, view_date) VALUES (:id_product, (SELECT id_user from published where  id_product = :id_product), 1, :current_date)";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_product" => $id_annoncement,
            "current_date" => $current_date
        ]);
    }

    function UpdateNumberView($id_annoncement)
    {
        $pdo = $this->connection;
        $requete = "UPDATE ProductView SET view_number = view_number + 1 WHERE id_product = :id";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id" => $id_annoncement
        ]);
    }

    // fonction pour la vérification bot
    function getLastViewVerifBot($id_product)
    {
        $pdo = $this->connection;
        $stmt = $pdo->prepare("
            SELECT view_date FROM ProductView 
            WHERE id_product = ? 
            ORDER BY view_date DESC 
            LIMIT 1
        ");
        $stmt->execute([$id_product]);
        return $stmt->fetch();
    }
}