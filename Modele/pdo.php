<?php

function connexion(){
    $host = "localhost";
    $dbname = "site_enchere";
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
        die("Erreur de connexion" .$e->getMessage());
    }
}

// Encryptage via code cesar depuis une méthode faite avant insertion
function inscription($nom, $prenom, $dateNaissance, $adresse, $ville, $Cp, $email, $password, $newsletter){
    $pdo = connexion();
    $requete = "INSERT INTO client (nom, prenom, date_de_naissance, adresse, ville, code_postale, email, mdp, newsletter) VALUES (:nom, :prenom, :date_de_naissance, :adresse, :ville, :code_postale, :email, :mdp, :newsletter)";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':date_de_naissance' => $dateNaissance,
            ':adresse' => $adresse,
            ':ville' => $ville,
            ':code_postale' => $Cp,
            ':email' => $email,
            ':mdp' => $password,
            ':newsletter' => $newsletter
        ]);
    }
    catch (PDOException $e){
        die("Erreur d'inscription, réessayez plus tard.\nDétail : " .$e->getMessage());
    }
}

// On part du principe de l'email et le password sont déja décripté
function authentification($email, $password){
    $pdo = connexion();
    $requete = "SELECT * from client where email = :email and mdp = :password";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':email' => $email,
            ':password' => $password
        ]);
    }
    catch (PDOException $e){
        die("Erreur d'authentification veillez vous reconnectez /n" .$e->getMessage());
    }
    return $tmp->fetch(PDO::FETCH_ASSOC);
}

function updateEmail($email, $idClient){
    $pdo = connexion();
    $requete = "UPDATE client
                SET email = :email
                where id_client = :idclient";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":email"=> $email,
            ":idclient"=> $idClient
        ]);
    }
    catch (PDOException $e){
        die("Erreur lors de la modification " .$e->getMessage());
    }
}

function SQL_updatePassword($idClient, $password){
    $pdo = connexion();
    $requete = "UPDATE client
                SET mdp = :pass
                Where id_client = :idclient";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":pass"=> $password,
            "idclient"=> $idClient
        ]);
    }
    catch (PDOException $e){
        die("Erreur lors de la modification du mot de passe" .$e->getMessage());
    }
}

function update_fullAdresse($adresse, $ville , $cp, $idClient ){
    $pdo = connexion();
    $requete = "UPDATE client
                set adresse = :new_adresse,
                    ville = :new_ville,
                    code_postale = :cp
                where id_client = :id";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":new_adresse"=> $adresse,
            ":new_ville"=> $ville,
            ":cp"=> $cp,
            ":id"=> $idClient
        ]);
    }
    catch (PDOException $e){
        die("Erreur lors de la modification de l'adresse complete" .$e->getMessage());
    }
}

function selectAdresse_client($idClient){
    $pdo = connexion();
    $requete = "SELECT adresse, code_postale, ville
                from client
                where id_client = :id
    ";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id"=> $idClient
        ]);
    }
    catch (PDOException $e){
        die("Erreur lors de la selection de l'adresse" .$e->getMessage());
    }

    // auto_completion 
    return $tmp->fetch(PDO::FETCH_ASSOC);
}

function getLastIdAnnonce(){
    $pdo = connexion();
    $requete = "SELECT MAX(id_annonce) as last_id FROM annonces";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
    }
    catch (PDOException $e){
        die("Erreur lors de la récupération du dernier id d'annonce" .$e->getMessage());
    }
    return $tmp->fetch(PDO::FETCH_ASSOC);
}

function getCategorie(){
    $pdo = connexion();
    $requete = "SELECT * FROM categorie";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
    }
    catch (PDOException $e){
        die("Erreur lors de la récupération des catégories" .$e->getMessage());
    }
    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}

<<<<<<< Updated upstream
function get_annonces_with_images(){
    $pdo = connexion();
    $requete = "SELECT * FROM annonces
                WHERE fini = 0  ";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
    }
    catch (PDOException $e){
        die("Erreur lors de la récupération des annonces" .$e->getMessage());
    }
    return $tmp->fetchAll(PDO::FETCH_ASSOC);
}

function get_images_for_annonce($id_annonce){
    $pdo = connexion();
    $requete = "SELECT nom FROM image
                WHERE id_annonce = :id_annonce";
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ':id_annonce' => $id_annonce
        ]);
    }
    catch (PDOException $e){
        die("Erreur lors de la récupération des images pour l'annonce" .$e->getMessage());
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
=======
function ajout_annonce($id_annonce, $nom, $description, $date_debut, $date_fin, $prix_actuelle, $prix_reserve, $rate, $fini, $id_client){
    $pdo = connexion();
    $requete = "INSERT INTO annonces (id_annonce, titre, description, date_de_debut, date_de_fin, prix_en_cours, prix_de_reserve, rate, fini)
                value (:id, :nom, :description, :date_debut, :date_fin, :prix_actuelle, :prix_reserve, :rate, :fini)
    ";  
    try{
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id"=> $id_annonce,
            ":nom"=> $nom,
            ":description"=> $description,
            ":date_debut"=> $date_debut,
            ":date_fin"=> $date_fin,
            ":prix_actuelle"=> $prix_actuelle,
            ":prix_reserve"=> $prix_reserve,
            ":rate"=> $rate,
            ":fini"=> $fini
        ]);
    }
    catch (PDOException $e){
        die("Erreur lors de l'insertion dans la base de votre annonce" .$e->getMessage());
    }

    
}
>>>>>>> Stashed changes
