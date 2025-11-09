<?php

function connection(){
    $host = "localhost";
    $dbname = "auction_site";
    $root = "root";
    $password = "";

    try{
        $pdo = new PDO("mysql:host=" .$host. ";dbname=" .$dbname. ";charset=utf8mb4", $root, $password);
        /// gpt
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ///
        return $pdo;
    }
    catch (PDOException $e){
        die("Connexion error !\nError : ".$e->getMessage());
    }
}

// Encryptage via code cesar depuis une méthode faite avant insertion
function inscription($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password){
    $pdo = connection();
    $requete = "INSERT INTO Users (name, firstname, birth_date, address, city, postal_code, email, password) VALUES (:name, :firstname, :birth_date, :address, :city, :postal_code, :email, :password)";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':name' => $name,
            ':firstname' => $firstname,
            ':birth_date' => $birth_date,
            ':address' => $address,
            ':city' => $city,
            ':postal_code' => $postal_code,
            ':email' => $email,
            ':password' => $password,
        ]);
    }
    catch (PDOException $e){
        die("Inscription error, try again later !\nError : " .$e->getMessage());
    }
}

// On part du principe de l'email et le password sont déja décripté
function authentication($email, $password){
    $pdo = connection();
    $requete = "SELECT * from Users where email = :email and password = :password";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':email' => $email,
            ':password' => $password
        ]);
    }
    catch (PDOException $e){
        die("Authentication error, try again ! /nError : " .$e->getMessage());
    }
    return $tmp->fetch(PDO::FETCH_ASSOC);
}

function updateEmailUser($email, $id_user){
    $pdo = connection();
    $requete = "UPDATE Users
                SET email = :email
                where id_user = :id_user";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":email"=> $email,
            ":id_user"=> $id_user
        ]);
    }
    catch (PDOException $e){
        die("Modification error, try again !\nError : " .$e->getMessage());
    }
}

function updatePasswordUser($id_user, $password){
    $pdo = connection();
    $requete = "UPDATE Users
                SET password = :password
                Where id_user = :id_user";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":password"=> $password,
            "id_user"=> $id_user
        ]);
    }
    catch (PDOException $e){
        die("Error during the modification of the password, try again !\nError : " .$e->getMessage());
    }
}

function updateFullAddress($address, $city , $postal_code, $id_user){
    $pdo = connection();
    $requete = "UPDATE Users
                set address = :address,
                    city = :city,
                    postal_code = :postal_code
                where id_user = :id_user";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":address"=> $address,
            ":city"=> $city,
            ":postal_code"=> $postal_code,
            ":id_user"=> $id_user
        ]);
    }
    catch (PDOException $e){
        die("Error during the modification of the adress, try again !\nError : " .$e->getMessage());
    }
}

function getAddress($id_user){
    $pdo = connection();
    $requete = "SELECT address, postal_code, city
                from Users
                where id_user = :id_user
    ";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_user"=> $id_user
        ]);
    }
    catch (PDOException $e){
        die("Error when selecting the address, try again !\nError : " .$e->getMessage());
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

function getCategory(){
    $pdo = connection();
    $requete = "SELECT * FROM category";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
    }
    catch (PDOException $e){
        die("Error retrieving categories, try again !\nError : " .$e->getMessage());
    }
    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}


function getAllProduct(){
    $pdo = connection();
    $requete = "SELECT * FROM Product";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
    }
    catch (PDOException $e){
        die("Error retrieving products, try again !\nError : " .$e->getMessage());
    }
    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}

function getImage($id_product){
    $pdo = connection();
    $requete = "SELECT * FROM image
                WHERE id_product = :id_product";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':id_product' => $id_product
        ]);
    }
    catch (PDOException $e){
        die("Error retrieving images for the product, try again !\nError : " .$e->getMessage());
    }
    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}

// function get_termined_annonces_by_client($id_client){
//     $pdo = connexion();
//     $requete = // Requete a faire 
//     try{
//         $tmp = $pdo->prepare($requete);
//         $tmp->execute([
//             ':id_client' => $id_client
//         ]);
//     }
//     catch (PDOException $e){
//         die("Erreur lors de la récupération des annonces terminées pour le client" .$e->getMessage());
//     }
//     return $tmp->fetchAll(PDO::FETCH_ASSOC);
// }

function addProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user){
    $pdo = connection();
    $requete1 = "INSERT INTO Product (title, description, start_date, end_date, reserve_price)
                values (:title, :description, :start_date, :end_date, :reserve_price);
    ";
    
    $requete2 = "INSERT INTO Published (id_product, id_user) values (:id_product, :id_user);";

    try{
        $temp = $pdo->prepare($requete1);
        $temp->execute([
            ":title"=> $title,
            ":description"=> $description,
            ":start_date"=> $start_date,
            ":end_date"=> $end_date,
            ":reserve_price"=> $reserve_price,
        ]);

        $id_product = $pdo->lastInsertId();

        $temp = $pdo->prepare($requete2);
        $temp->execute([
            ":id_product"=> $id_product,
            ":id_user"=> $id_user
        ]);
    }
    catch (PDOException $e){
        die("Error inserting your product into the database, try again !\n Error : " .$e->getMessage());
    }
}
