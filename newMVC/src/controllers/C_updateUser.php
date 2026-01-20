<?php

require_once('src/model/user.php');
require_once('src/lib/database.php');

function updateEmail(string $email)
{
    if (!empty($email)) {
        $user = $_SESSION["user"];
        $id_user = $user["id_user"];

        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $userRepository->updateEmailUser($email, $id_user);
        $_SESSION["user"]["email"] = $email;

        echo "Mail bien modifié";
        header("Location: index.php?action=user");
        exit();
    } else {
        throw new Exception("Données du formulaire manquantes.");
    }
}

function updatePassword($post)
{
    if (!empty($post["old_password"]) && !empty($post["new_password_1"]) && !empty($post["new_password_2"])) {
        $oldPass = trim(htmlentities(password_hash($post["old_password"], PASSWORD_ARGON2ID)));
        $newPass = trim(htmlentities($post["new_password_1"]));
        $confirmPass = trim(htmlentities($post["new_password_2"]));
    
        $oldPassDatabase = $_SESSION["user"]["password"];
        
        if ($oldPassDatabase == $oldPass ){
            if( $newPass == $confirmPass){
                $user = $_SESSION["user"];
                $id_user = $user["id_user"];
                $newPass = trim(htmlentities(password_hash($newPass, PASSWORD_ARGON2ID)));
            } 
            $pdo = DatabaseConnection::getConnection();
            $userRepository = new UserRepository($pdo);
            $userRepository->updatePasswordUser($id_user, $newPass);
            $_SESSION["user"]["password"] = $newPass;
        } else {
            throw new Exception("L'ancien mot de passe est incorrect.");
        }
        header("Location: index.php?action=user");
        exit();
    } else {
        throw new Exception("Données du formulaire manquantes.");
    }
}

function updateAddress(array $input)
{
    $user = $_SESSION["user"];
    $id_user = $user["id_user"];
    $address = $input["address"];
    $city = $input["city"];
    $postal_code = $input["postal_code"];
    if (!empty($input["address"]) && !empty($input["city"]) && !empty($input["postal_code"])) {
        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $userRepository->updateFullAddress($input["address"], $input["city"], $input["postal_code"], $id_user);
        $address = $userRepository->getAddress($id_user);
        $strAddress = "";
        foreach ($address as $a) {
            $strAddress .= $a . " ";
        }
        $strAddress = trim($strAddress);
        $_SESSION["user"]["address"] = $strAddress;

        header("Location: index.php?action=user");
        exit();
    }
}

function updateFirstname($f){
    if (isset($f)){
        $firstname = $f;
        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $userRepository->updateFirstnameUser($firstname, $_SESSION['user']['id_user']);
        $_SESSION['user']['firstname'] = $firstname['firstname'];
        
        header("Location: index.php?action=user");
        exit();
    }
}

function updateName($f){
    if (isset($f)){
        $name = $f;
        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $userRepository->updateNameUser($name, $_SESSION['user']['id_user']);
        $_SESSION['user']['name'] = $name['name'];
        
        header("Location: index.php?action=user");
        exit();
    }
}
