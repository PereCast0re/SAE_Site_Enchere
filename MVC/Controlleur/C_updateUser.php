<?php

session_start();

require_once("../Modele/pdo.php");

if (isset($_POST["action"])) {
    $action = $_POST["action"];

    switch ($action) {
        case "update_email":
            $email = $_POST["new_email"];
            updateEmail($email);
            break;
        case "update_password":
            $password = $_POST["new_password_2"];
            updatePassword($password);
            break;
        case "update_address":
            updateAddress();
            break;
        default:
            echo"Action non répertorié";
            break;
    }
}

function updateEmail($email){
    if(isset($email)){
        $user = $_SESSION["user"];
        $id_user = $user["id_user"];

        updateEmailUser($email, $id_user);
        $_SESSION["user"]["email"] = $email;

        echo"Mail bien midifié";
        header("Location: ../Vue/user.php");
        exit();
    }else {
        echo "Données du formulaire manquantes.";
    }
} 

function updatePassword($password){
    if(isset($password)){
        $user = $_SESSION["user"];
        $id_user = $user["id_user"];

        updatePasswordUser($id_user, $password);
        $_SESSION["user"]["password"] = $password;

        header("Location: ../Vue/user.php");
        exit();
    }else {
        echo "Données du formulaire manquantes.";
    }
} 

function updateAddress(){
    $user = $_SESSION["user"];
    $id_user = $user["id_user"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $postal_code = $_POST["postal_code"];
    if (isset($address) && isset($city) && isset($postal_code)){
        updateFullAddress($address, $city, $postal_code, $id_user);
        $address = getAddress($id_user);
        $strAddress = "";
        foreach($address as $a) {
            $strAddress .= $a . " ";
        }
        $strAddress = trim($strAddress);
        $_SESSION["user"]["address"] = $strAddress;

        header("Location: ../Vue/user.php");
        exit();
    }
}