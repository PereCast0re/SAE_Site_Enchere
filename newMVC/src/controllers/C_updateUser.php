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

function updatePassword(string $password)
{
    if (!empty($password)) {
        $user = $_SESSION["user"];
        $id_user = $user["id_user"];
        $pass = trim(htmlentities(password_hash($password, PASSWORD_ARGON2ID)));

        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $userRepository->updatePasswordUser($id_user, $pass);
        $_SESSION["user"]["password"] = $password;

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