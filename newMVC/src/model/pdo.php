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

function createUser($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password)
{
    $pdo = connection();
    $requete = "INSERT INTO Users (name, firstname, birth_date, address, city, postal_code, email, password) VALUES (:name, :firstname, :birth_date, :address, :city, :postal_code, :email, :password)";
    try {
        $tmp = $pdo->prepare($requete);
        return $tmp->execute([
            ':name' => $name,
            ':firstname' => $firstname,
            ':birth_date' => $birth_date,
            ':address' => $address,
            ':city' => $city,
            ':postal_code' => $postal_code,
            ':email' => $email,
            ':password' => $password,
        ]);
    } catch (PDOException $e) {
        die("Inscription error, try again later !\nError : " . $e->getMessage());
    }
}

// On part du principe de l'email et le password sont déja décripté
function authentication($email, $password)
{
    $pdo = connection();
    $requete = "SELECT * from Users where email = :email and password = :password";
    try {
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':email' => $email,
            ':password' => $password
        ]);
    } catch (PDOException $e) {
        die("Authentication error, try again ! /nError : " . $e->getMessage());
    }
    return $tmp->fetch(PDO::FETCH_ASSOC);
}

function updateEmailUser($email, $id_user)
{
    $pdo = connection();
    $requete = "UPDATE Users
                SET email = :email
                where id_user = :id_user";
    try {
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":email" => $email,
            ":id_user" => $id_user
        ]);
    } catch (PDOException $e) {
        die("Modification error, try again !\nError : " . $e->getMessage());
    }
}

function updatePasswordUser($id_user, $password)
{
    $pdo = connection();
    $requete = "UPDATE Users
                SET password = :password
                Where id_user = :id_user";
    try {
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":password" => $password,
            "id_user" => $id_user
        ]);
    } catch (PDOException $e) {
        die("Error during the modification of the password, try again !\nError : " . $e->getMessage());
    }
}

function updateFullAddress($address, $city, $postal_code, $id_user)
{
    $pdo = connection();
    $requete = "UPDATE Users
                set address = :address,
                    city = :city,
                    postal_code = :postal_code
                where id_user = :id_user";
    try {
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":address" => $address,
            ":city" => $city,
            ":postal_code" => $postal_code,
            ":id_user" => $id_user
        ]);
    } catch (PDOException $e) {
        die("Error during the modification of the adress, try again !\nError : " . $e->getMessage());
    }
}

function getAddress($id_user)
{
    $pdo = connection();
    $requete = "SELECT address, postal_code, city
                from Users
                where id_user = :id_user
    ";
    try {
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_user" => $id_user
        ]);
    } catch (PDOException $e) {
        die("Error when selecting the address, try again !\nError : " . $e->getMessage());
    }

    // auto_completion 
    return $tmp->fetch(PDO::FETCH_ASSOC);
}

// function getLastIdAnnonce(){
//     $pdo = connection();
//     $requete = "SELECT MAX(id_annonce) as last_id FROM annonces";
//     try{
//         $tmp = $pdo->prepare($requete);
//         $tmp->execute();
//     }
//     catch (PDOException $e){
//         die("Erreur lors de la récupération du dernier id d'annonce" .$e->getMessage());
//     }
//     return $tmp->fetch(PDO::FETCH_ASSOC);
// }

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

function get_price_annoncement($id_annoncement)
{
    $pdo = connection();
    $request = "SELECT MAX(new_price) from bid join product on product.id_product = bid.id_product where bid.id_product = :id_product";
    try {
        $tmp = $pdo->prepare($request);
        $tmp->execute([
            ":id_product" => $id_annoncement
        ]);
    } catch (PDOException $e) {
        die("Error on extraction of current bid on your annoncement" . $e->getMessage());
    }

    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}

// function getAnnonce($id_annoncement){
//     $pdo = connection();
//     $request = "SELECT * from product where id_product = :id";
//     try{
//         $tmp = $pdo->prepare($request);
//         $tmp->execute([
//             ":id" => $id_annoncement
//         ]);
//         } catch (PDOException $e){
//             die("Error on the extraction of this product " .$e->getMessage());
//         }
//     // Retourner une seule annonce (row) plutôt qu'un tableau de lignes
//     return $tmp->fetch(PDO::FETCH_ASSOC);
// }

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

function setProductFavorite($id_product, $id_user)
{
    $pdo = connection();
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
    $pdo = connection();
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
    $pdo = connection();
    $request = "DELETE FROM Interest WHERE id_product = :id_product AND id_user = :id_user";
    $temp = $pdo->prepare($request);
    $success = $temp->execute([
        ':id_product' => $id_product,
        ':id_user' => $id_user
    ]);

    return $success;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Bid Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function bidProduct($id_product, $id_user, $newPrice, $currentPrice = null)
{
    if ($currentPrice === null) {
        $currentPrice = getLastPrice($id_product)['last_price'];
    }
    $pdo = connection();
    $request = "INSERT INTO Bid(id_product, id_user, current_price, new_price, bid_date) VALUES (:id_product, :id_user, :current_price, :new_price, NOW())";
    $temp = $pdo->prepare($request);
    $success = $temp->execute([
        ':id_product' => $id_product,
        ':id_user' => $id_user,
        ':current_price' => $currentPrice,
        ':new_price' => $newPrice
    ]);

    return $success;
}

function getLastBidder($id_product)
{
    $pdo = connection();
    $request = "SELECT id_user FROM bid WHERE new_price IN (
    SELECT MAX(new_price) FROM bid WHERE id_product = ?
    );";
    $temp = $pdo->prepare($request);
    $temp->execute([$id_product]);

    return $temp->fetchColumn();
}

function getProductDate($id_product)
{
    $pdo = connection();
    $request = "SELECT end_date FROM Product WHERE id_product = ?";
    $temp = $pdo->prepare($request);
    $temp->execute([$id_product]);

    return $temp->fetchColumn();
}

function addTime($id_product)
{
    $pdo = connection();
    $request = "UPDATE Product SET end_date = DATE_ADD(end_date, INTERVAL 30 SECOND) WHERE id_product = ?";
    $temp = $pdo->prepare($request);
    $success = $temp->execute([$id_product]);

    return $success;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Comment Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getCommentsFromProduct($id_product)
{
    $pdo = connection();
    $request = "SELECT CONCAT(u.firstname, ' ', u.name) AS full_name, c.comment, c.comment_date, c.id_user FROM Comment c JOIN Users u ON u.id_user = c.id_user WHERE id_product = :id_product ORDER BY comment_date DESC";
    $temp = $pdo->prepare($request);
    $temp->execute([
        "id_product" => $id_product
    ]);

    return $temp->fetchAll(PDO::FETCH_ASSOC);
}

function addCommentToProduct($id_product, $id_user, $comment)
{
    $pdo = connection();
    $request = "INSERT INTO Comment VALUES (:id_product, :id_user, :comment, NOW())";
    $temp = $pdo->prepare($request);
    $success = $temp->execute([
        "id_product" => $id_product,
        "id_user" => $id_user,
        "comment" => $comment
    ]);

    return $success;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//User Section//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getUser($id_user)
{
    $pdo = connection();
    $request = "SELECT * FROM Users WHERE id_user = :id_user";
    $temp = $pdo->prepare($request);
    $temp->execute([
        "id_user" => $id_user
    ]);

    return $temp->fetch(PDO::FETCH_ASSOC);
}

function getRatingUser($id_user)
{
    $pdo = connection();
    $request = "SELECT AVG(rating) as score FROM Rating WHERE id_seller = :id_user";
    $temp = $pdo->prepare($request);
    $temp->execute([
        "id_user" => $id_user
    ]);

    return $temp->fetchColumn();
}

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
    $requete = "SELECT *, MAX(bid.new_price)
                FROM product as p
                join published as publi on publi.id_product = p.id_product
                join bid on bid.id_product = p.id_product
                where publi.id_user = :id_user and p.end_date < CURRENT_DATE and p.reserve_price > 0
                ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        "id_user" => $id_user
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
                LIMIT 5;
                ";
    $temp = $pdo->prepare($requete);
    $temp->execute([
        "id_user" => $id_user
    ]);

    return $temp->fetchAll(PDO::FETCH_ASSOC);
}