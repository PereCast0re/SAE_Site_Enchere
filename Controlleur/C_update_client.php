<?php

session_start();

require_once("../Modele/pdo.php");

if (isset($_POST["action"])) {
    $action = $_POST["action"];

    switch ($action) {
        case "update_email":
            $email = $_POST["new_email"];
            updateMail($email);
            break;
        case "update_password":
            $password = $_POST["new_password_2"];
            updatePassword($password);
            break;
        case "update_Adresse":
            update_Adresse();
            break;
        default:
            echo"Action non répertorié";
            break;
    }
}

function updateMail($email){
    if(isset($email)){
        $client = $_SESSION["client"];
        $idClient = $client["id_client"];

        updateEmail($email, $idClient);
        $_SESSION["client"]["email"] = $email;

        echo"Mail bien midifié";
        header("Location: ../Vue/client.php");
        exit();
    }else {
        echo "Données du formulaire manquantes.";
    }
} 

function updatePassword($password){
    if(isset($password)){
        $client = $_SESSION["client"];
        $idClient = $client["id_client"];

        SQL_updatePassword($idClient, $password);
        $_SESSION["client"]["mdp"] = $password;

        header("Location: ../Vue/client.php");
        exit();
    }else {
        echo "Données du formulaire manquantes.";
    }
} 

function update_Adresse(){
    $client = $_SESSION["client"];
    $idClient = $client["id_client"];
    $adresse = $_POST["new_adresse"];
    $ville = $_POST["new_ville"];
    $cp = $_POST["new_cp"];
    if (isset($adresse) && isset($ville) && isset($cp)){
        update_fullAdresse($adresse, $ville, $cp, $idClient);
        $adresse = selectAdresse_client($idClient);
        $strAdresse = "";
        foreach($adresse as $a) {
            $strAdresse .= $a . " ";
        }
        $strAdresse = trim($strAdresse);
        $_SESSION["client"]["adresse"] = $strAdresse;

        header("Location: ../Vue/client.php");
        exit();
    }
}