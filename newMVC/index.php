<?php

session_start();

require_once('src/controllers/C_addProduct.php');
require_once('src/controllers/C_connection.php');
require_once('src/controllers/C_inscription.php');
require_once('src/controllers/C_pageProduct.php');
require_once('src/controllers/C_pageUser.php');
require_once('src/controllers/C_updateUser.php');
require_once("src/model/pdo.php");

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'connection') {
            require("templates/connection.php");
        } elseif ($_GET['action'] === 'inscription') {
            require("templates/inscription.php");
        } elseif ($_GET['action'] === 'user') {
            require("templates/user.php");
        } elseif ($_GET['action'] === 'sell') {
            require("templates/sellProduct.php");


        } elseif ($_GET['action'] === 'userConnection') {
            userConnection($_POST);
        } elseif ($_GET['action'] === 'userInscription') {
            inscription($_POST);


        } elseif ($_GET['action'] === 'update_email') {
            updateEmail($_POST['email']);
        } elseif ($_GET['action'] === 'update_address') {
            updateAddress($_POST);
        } elseif ($_GET['action'] === 'update_password') {
            updatePassword($_POST['new_password_2']);

        } elseif ($_GET['action'] === 'addProduct') {
            $id_user = $_SESSION['user']['id_user'];
            addProduct($id_user, $_POST);
        } elseif ($_GET['action'] === 'historique_annonces_publiees') {
            require("templates/historique_annonces_publiees.php");
            


        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        require("templates/index.php");
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/preset/error.php');
}