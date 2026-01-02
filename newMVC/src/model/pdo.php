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