<?php

require_once('src/model/user.php');
require_once('src/lib/database.php');

// if (isset($_POST["action"])) {
//     $action = $_POST["action"];

//     switch ($action) {
//         case "update_email":
//             $email = $_POST["new_email"];
//             updateEmail($email);
//             break;
//         case "update_password":
//             $password = $_POST["new_password_2"];
//             updatePassword($password);
//             break;
//         case "update_address":
//             updateAddress();
//             break;
//         default:
//             echo"Action non répertorié";
//             break;
//     }
// }

function updateEmail(string $email)
{
    if (!empty($email)) {
        $user = $_SESSION["user"];
        $id_user = $user["id_user"];

        $userRepository = new UserRepository();
        $userRepository->connection = new DatabaseConnection();
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

        $userRepository = new UserRepository();
        $userRepository->connection = new DatabaseConnection();
        $userRepository->updatePasswordUser($id_user, $password);
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
        $userRepository = new UserRepository();
        $userRepository->connection = new DatabaseConnection();
        $userRepository->updateFullAddress($input["address"], $input["city"], $input["postal_code"], $id_user);
        $address = getAddress($id_user);
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