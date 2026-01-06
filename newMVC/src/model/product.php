<?php

require_once('src/lib/database.php');

class ProductRepository
{

    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function getCategory()
    {
        $pdo = connection();
        $requete = "SELECT * FROM category";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute();
        } catch (PDOException $e) {
            die("Error retrieving categories, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }


    function getAllProduct()
    {
        $pdo = connection();
        $requete = "SELECT * FROM Product";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute();
        } catch (PDOException $e) {
            die("Error retrieving products, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProduct($id_product)
    {
        $pdo = connection();
        $requete = "SELECT * FROM Product WHERE id_product = ?";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([$id_product]);
        } catch (PDOException $e) {
            die("Error retrieving product, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function get_termined_annonces_by_client($id_client)
    {
        $pdo = connection();
        $requete = "
        SELECT
            p.id_product,
            p.title AS titre,
            p.description,
            p.end_date,
            p.reserve_price,
            COALESCE(MAX(b.new_price), p.reserve_price) AS prix_en_cours
        FROM product p
        JOIN published pb ON pb.id_product = p.id_product
        LEFT JOIN bid b ON b.id_product = p.id_product
        WHERE pb.id_user = :id_client
        AND p.end_date < NOW()
        GROUP BY p.id_product, p.title, p.description, p.end_date, p.reserve_price
        ORDER BY p.end_date DESC
    ";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_client' => $id_client
            ]);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des annonces terminées pour le client : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_actual_annonces_by_client($id_client)
    {
        $pdo = connection();
        $requete = "
        SELECT
            p.id_product,
            p.title AS titre,
            p.description,
            p.end_date,
            p.reserve_price,
            COALESCE(MAX(b.new_price), p.reserve_price) AS prix_en_cours
        FROM product p
        JOIN published pb ON pb.id_product = p.id_product
        LEFT JOIN bid b ON b.id_product = p.id_product
        WHERE pb.id_user = :id_client
        AND p.end_date >= NOW()
        GROUP BY p.id_product, p.title, p.description, p.end_date, p.reserve_price
        ORDER BY p.end_date ASC
    ";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_client' => $id_client
            ]);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des annonces en cours pour le client : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user, $status)
    {
        $pdo = connection();
        $requete1 = "INSERT INTO Product (title, description, start_date, end_date, reserve_price, status)
                values (:title, :description, :start_date, :end_date, :reserve_price, :status);
    ";

        $requete2 = "INSERT INTO Published (id_product, id_user) values (:id_product, :id_user);";

        try {
            $temp = $pdo->prepare($requete1);
            $temp->execute([
                ":title" => $title,
                ":description" => $description,
                ":start_date" => $start_date,
                ":end_date" => $end_date,
                ":reserve_price" => $reserve_price,
                ":status" => $status,
            ]);

            $id_product = $pdo->lastInsertId();

            $temp = $pdo->prepare($requete2);
            $temp->execute([
                ":id_product" => $id_product,
                ":id_user" => $id_user
            ]);

            return $id_product;
        } catch (PDOException $e) {
            die("Error inserting your product into the database, try again !\n Error : " . $e->getMessage());
        }
    }

    function deleteProduct($id_product)
    {
        $pdo = connection();
        $request = "DELETE FROM Product WHERE id_product = ?";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([$id_product]);

        return $success;
    }

    function addImage($id_product, $path_image, $name_image)
    {
        $pdo = connection();
        try {
            $requete2 = "INSERT INTO image (id_product, path_image, alt) VALUES (:id_product, :path_image, :name_image)";

            $temp = $pdo->prepare($requete2);
            $temp->execute([
                ":id_product" => $id_product,
                ":path_image" => $path_image,
                ":name_image" => $name_image
            ]);

            return true;

        } catch (PDOException $e) {
            die("Error inserting your image into the database, try again !\nError : " . $e->getMessage());
        }
    }

    function get_Annonce_User($id_client)
    {
        $pdo = connection();
        $request = "SELECT * 
                from product as p 
                join published as pb on pb.id_product = p.id_product
                where pb.id_user = :id_client and p.end_date > date(now())
                ";
        try {
            $temp = $pdo->prepare($request);
            $temp->execute([
                "id_client" => $id_client
            ]);
        } catch (PDOException $e) {
            die("Error on extraction of your announcement" . $e->getMessage());
        }

        return $temp->fetchAll(PDO::FETCH_ASSOC);
    }

    function getLastPrice($id_product)
    {
        $pdo = connection();
        $requete1 = "SELECT MAX(new_price) as last_price
                from bid
                where id_product = :id_product";
        try {
            $tmp = $pdo->prepare($requete1);
            $tmp->execute([
                ':id_product' => $id_product
            ]);
        } catch (PDOException $e) {
            die("Error retrieving the last price for the product, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }
}