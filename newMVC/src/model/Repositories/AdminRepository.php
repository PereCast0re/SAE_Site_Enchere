<?php

namespace App\Model\Repositories;

use PDOException;
use PDO;

class AdminRepository {
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function getAllProduct_admin()
    {
        $pdo = $this->connection;
        $requete = "SELECT * FROM Product where status = 0 ";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute();
        } catch (PDOException $e) {
            die("Error retrieving products, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProductsByCategory($id_category)
    {
        $pdo = $this->connection;
        $requete = "SELECT Product.*, celebrity.name AS celebrity_name
                    FROM Product
                    JOIN belongsto ON Product.id_product = belongsto.id_product
                    JOIN concerned ON Product.id_product = concerned.id_product
                    JOIN Celebrity ON concerned.id_celebrity = Celebrity.id_celebrity
                    WHERE belongsto.id_category = :id_category";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_category" => $id_category
        ]);
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProductsByCelebrity($id_celebrity)
    {
        $pdo = $this->connection;
        $requete = "SELECT Product.*, celebrity.name AS celebrity_name
                    FROM Product
                    JOIN concerned ON Product.id_product = concerned.id_product
                    JOIN Celebrity ON concerned.id_celebrity = Celebrity.id_celebrity
                    WHERE concerned.id_celebrity = :id_celebrity";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_celebrity" => $id_celebrity
        ]);
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }
}