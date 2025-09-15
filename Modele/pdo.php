<?php

function connexion(){
    $host = "localhost";
    $dbname = "site_enchere";
    $root = "root";
    $password = "";

    try{
        $pdo = new PDO("mysql:host=" + $host + ";dbname=" + $dbname + ";charset=utf8mb4_unicode_ci", $root, $password);
        /// gpt
        $pdo->setAttribute(PDO::AFTER_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ///
        return $pdo;
    }
    catch (PDOException $e){
        die("Erreur de connexion" + e.getMessage());
    }
}

// Encryptage via code cesar depuis une méthode faite avant insertion
function inscription($nom, $prenom, $dateNaissance, $adresse, $ville, $Cp, $email, $password, $newsletter){
    $pdo = connexion();
    $reqete = "Insert into client values ( :nom, :prenom, :date_de_naissance, :adresse, :ville, :code_postale, :email, :mdp, :newsletter )";
    try{
        $tmp = $pdo->prepare($sql)
        $tmp->execute([
            ':nom' -> $nom,
            ':prenom' -> $prenom,
            ':date_de_naissance' -> $dateNaissance,
            ':adresse' -> $adresse,
            ':ville' -> $ville,
            ':code_postale' -> $Cp,
            ':email' -> $email,
            ':mdp' -> $password,
            ':newsletter' -> 'NULL'
        ]);
    }
    catch (PDOException $e){
        die("Erreur d'inscription re-tester plus tard. /n Détail :" .$e->getMessage());
    }
}

// On part du principe de l'email et le password sont déja décripté
function authentification($email, $password){
    $pdo = connexion()
    $reqete = "Select * from client where email = :email and mdp = :password";
    try{
        $tmp = $pdo->prepare($sql)
        $tmp->execute([
            ':email' -> $email,
            ':password' -> $password
        ]);
    }
    catch (PDOException $e){
        die("Erreur d'authentification veillez vous reconnectez /n" .$e->getMessage());
    }
}
