<?php

date_default_timezone_set('Europe/Paris');

function connection()
{
    $host = "localhost";
    $dbname = "auction_site";
    $root = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8mb4", $root, $password);
        /// gpt
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ///
        return $pdo;
    } catch (PDOException $e) {
        die("Connexion error !\nError : " . $e->getMessage());
    }
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

function createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user)
{
    $pdo = connection();
    $requete1 = "INSERT INTO Product (title, description, start_date, end_date, reserve_price)
                values (:title, :description, :start_date, :end_date, :reserve_price);
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Favorite Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Bid Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Comment Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//User Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/// Wee have to verif if the date is correctly compared
function getDailyViews($id_product)
{
    $pdo = connection();
    $requete = " SELECT COUNT(view_number) as nbDailyView from productview where id_product = :id and view_date = date(now()) ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id" => $id_product
    ]);
    return $temp->fetch(PDO::FETCH_ASSOC);
}

function getGlobalViews($id_product)
{
    $pdo = connection();
    $requete = " SELECT SUM(view_number) as nbGlobalView from productview where id_product = :id ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id" => $id_product
    ]);
    return $temp->fetch(PDO::FETCH_ASSOC);
}

function getLikes($id_product)
{
    $pdo = connection();
    $requete = " SELECT COUNT(*) as nbLike from interest where id_product = :id ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id" => $id_product
    ]);
    return $temp->fetch(PDO::FETCH_ASSOC);
}

function getImage($id_product)
{
    $pdo = connection();
    $requete = " SELECT path_image as url_image, alt from image where id_product = :id";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id" => $id_product
    ]);
    return $temp->fetchAll(PDO::FETCH_ASSOC);
}
/*
function getImageCategory($id_category)
{
    $pdo = connection();
    // recuperer la premiere image de la premiere annonce de cette categorie avec une image
    $requete = " SELECT img.path_image as url_image, img.alt from image img
                join product p on p.id_product = img.id_product
                join belongsto bel on bel.id_product = p.id_product, bel.id_category
                join category c on c.id_category = bel.id_category
                where c.id_category = :id_category
                LIMIT 1 ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id_category" => $id_category
    ]);
    return $temp->fetchAll(PDO::FETCH_ASSOC);
}
    */

function getAnnoncementEndWithReservedPrice($id_user)
{
    $pdo = connection();
        $requete = "SELECT p.*, publi.*, MAX(b.new_price) AS new_price,p.reserve_price
                    FROM product AS p
                    JOIN published AS publi ON publi.id_product = p.id_product
                    LEFT JOIN bid AS b ON b.id_product = p.id_product
                    WHERE 
                        publi.id_user = :id_user 
                        AND p.end_date < CURRENT_DATE 
                        AND p.reserve_price > 0
                    GROUP BY p.id_product  
                    HAVING MAX(b.new_price) < p.reserve_price OR MAX(b.new_price) IS NULL"; 

    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id_user" => $id_user
    ]);

    
    return $temp->fetchAll(PDO::FETCH_ASSOC);
}

function getListFinishedAnnoncements($id_user)
{
    $pdo = connection();
    $requete = "SELECT
                p.*,
                publi.*,
                MAX(b.new_price) AS last_price
                FROM product p
                JOIN published publi
                ON publi.id_product = p.id_product
                LEFT JOIN bid b
                ON b.id_product = p.id_product
                WHERE publi.id_user = :id_user
                AND p.end_date < CURRENT_DATE
                GROUP BY p.id_product
                HAVING last_price IS NULL OR last_price = 0 
                LIMIT 5;

                ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id_user" => $id_user
    ]);

    return $temp->fetchAll(PDO::FETCH_ASSOC);
}

function gethashPassword($email){
    $pdo = connection();
    $requete = "SELECT password from users where email = :email ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":email" => $email 
    ]);

    $result = $temp->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['password'] : null;
}