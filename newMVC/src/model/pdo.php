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
//User Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

function getAnnoncementEndWithReservedPrice($id_user)
{
    $pdo = connection();
    $requete = "SELECT p.*, publi.*, MAX(b.new_price) AS new_price,p.reserve_price
                    FROM product AS p
                    JOIN published AS publi ON publi.id_product = p.id_product
                    LEFT JOIN bid AS b ON b.id_product = p.id_product
                    WHERE 
                        publi.id_user = :id_user 
                        AND p.end_date < NOW()
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
                AND p.end_date < NOW()
                GROUP BY p.id_product
                HAVING last_price IS NULL OR last_price = 0 
                ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":id_user" => $id_user
    ]);

    return $temp->fetchAll(PDO::FETCH_ASSOC);
}

function gethashPassword($email)
{
    $pdo = connection();
    $requete = "SELECT password from users where email = :email ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        ":email" => $email
    ]);

    $result = $temp->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['password'] : null;
}

////////////////////////////////////////////////////////////////////////////
// Ajout d'une vue a une annonce //
///////////////////////////////////////////////////////////////////////////
function getViewProduct($id_annoncement, $current_date)
{
    $pdo = connection();
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
    $pdo = connection();
    $requete = "INSERT into productview (id_product, id_user, view_number, view_date) VALUES (:id_product, (SELECT id_user from published where  id_product = :id_product), 1, :current_date)";
    $tmp = $pdo->prepare($requete);
    $tmp->execute([
        ":id_product" => $id_annoncement,
        "current_date" => $current_date
    ]);
}

function UpdateNumberView($id_annoncement)
{
    $pdo = connection();
    $requete = "UPDATE ProductView SET view_number = view_number + 1 WHERE id_product = :id";
    $tmp = $pdo->prepare($requete);
    $tmp->execute([
        ":id" => $id_annoncement
    ]);
}

// fonction pour la vérification bot
function getLastViewVerifBot($id_product)
{
    $pdo = connection();
    $stmt = $pdo->prepare("
        SELECT view_date FROM ProductView 
        WHERE id_product = ? 
        ORDER BY view_date DESC 
        LIMIT 1
    ");
    $stmt->execute([$id_product]);
    return $stmt->fetch();
}

function saveCertificatePath($id_product, $path_image)
{
    $pdo = connection();
    try {
        $requete2 = "INSERT INTO image (id_product, path_image, alt) VALUES (:id_product, :path_image, :name_image)";

        $temp = $pdo->prepare($requete2);
        $temp->execute([
            ":id_product" => $id_product,
            ":path_image" => $path_image,
            ":name_image" => $id_product . "Certificate.pdf"
        ]);

        return true;

    } catch (PDOException $e) {
        die("Error inserting your image into the database, try again !\nError : " . $e->getMessage());
    }
}


function subscribeNewsletter($email)
{
    $pdo = connection();
    try {
        $requete = "UPDATE users SET newsletter = 1 WHERE email = :email";
        $temp = $pdo->prepare($requete);
        $temp->execute([
            ":email" => $email
        ]);
    } catch (PDOException $e) {
        die("Error subscribing to the newsletter, try again !\nError : " . $e->getMessage());
    }
    
}


///////////////////////////////////////////// Cloture d'une annonce ////////////////////////////////////////////////////////
/// Si mailIsSent = 1 alors l'email et deja evoyé et permet de bloqué les envois multiples
function closeAnnoncement($id_product)
{
    $pdo = connection();
    $requete = "UPDATE product SET end_date = now(), mailIsSent = 1 WHERE id_product = :id_product";
    $tmp = $pdo->prepare($requete);
    $tmp->execute([
        ":id_product" => $id_product
    ]);
}

function get_all_annoncement_notMailed()
{
    $pdo = connection();
    $requete = 'SELECT * from product where mailIsSent != 1';
    $tmp = $pdo->prepare($requete);
    $tmp->execute();
    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}


/////////////////////////////////// Admin ////////////////////////////////////////////
function getAllProduct_admin()
{
    $pdo = connection();
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
    $pdo = connection();
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
    $pdo = connection();
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

