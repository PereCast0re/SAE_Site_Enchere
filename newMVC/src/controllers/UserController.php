<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;
use App\Model\Repositories\ProductRepository;
use Exception;

class UserController
{
    private NotificationsController $notificationsController;

    public function __construct()
    {
        $this->notificationsController = new NotificationsController();
    }

    function inscription(array $input)
    {
        // Vérifier que le formulaire a bien été soumis
        if (
            isset(
            $input['name'],
            $input['firstname'],
            $input['birth_date'],
            $input['address'],
            $input['city'],
            $input['postal_code'],
            $input['email'],
            $input['password']
        )
        ) {
            // Ne pas remettre de html_entities ou htmlchars, on ne sauvegarde pas des données filtrées dans la base,
            // seulement au retour que les données doivent être filtrées à l'affichage
            $name = trim($input['name']);
            $firstname = trim($input['firstname']);
            $birth_date = trim($input['birth_date']);
            $address = trim($input['address']);
            $city = trim($input['city']);
            $postal_code = trim($input['postal_code']);
            $email = trim($input['email']);
            $password = trim(password_hash($input['password'], PASSWORD_ARGON2ID));
        } else {
            throw new Exception("Les données du formulaire sont invalides !");
        }

        // Appel de la fonction d'incription
        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $success = $userRepository->createUser($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password);
        if (!$success) {
            throw new Exception("Impossible de s'inscrire pour le moment !");
        } else {
            // Redirection ou message de succès
            $this->notificationsController->routeurMailing('InscriptionWebsite', [$email, $name . ' ' . $firstname]);
            header('Location: index.php?action=user');
        }
    }

    function get_all_annoncement($id_user)
    {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $tab_annoncements = $productRepository->get_Annonce_User($id_user);
        return $tab_annoncements;
    }

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

            if ($oldPassDatabase == $oldPass) {
                if ($newPass == $confirmPass) {
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

    function updateFirstname($f)
    {
        if (isset($f)) {
            $firstname = $f;
            $pdo = DatabaseConnection::getConnection();
            $userRepository = new UserRepository($pdo);
            $userRepository->updateFirstnameUser($firstname, $_SESSION['user']['id_user']);
            $_SESSION['user']['firstname'] = $firstname['firstname'];

            header("Location: index.php?action=user");
            exit();
        }
    }

    function updateName($f)
    {
        if (isset($f)) {
            $name = $f;
            $pdo = DatabaseConnection::getConnection();
            $userRepository = new UserRepository($pdo);
            $userRepository->updateNameUser($name, $_SESSION['user']['id_user']);
            $_SESSION['user']['name'] = $name['name'];

            header("Location: index.php?action=user");
            exit();
        }
    }

    function userProfil()
    {
        if (isset($_GET['id']) && $_GET['id'] >= 0) {
            $pdo = DatabaseConnection::getConnection();
            $userRepository = new UserRepository($pdo);
            $score = $userRepository->getRatingUser($_GET['id']);
            $score == null ? $score = 0 : $score;

            $productRepository = new ProductRepository($pdo);
            $products = $productRepository->get_Annonce_User($_GET['id']);
            $u = $userRepository->getUser($_GET['id']);
            require("templates/userProfil.php");
        } else {
            require("templates/user.php");
        }
    }
}