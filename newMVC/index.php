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
////////////////////////////// Pages //////////////////////////////
        if ($_GET['action'] === 'connection') {
            require("templates/connection.php");
        } elseif ($_GET['action'] === 'inscription') {
            require("templates/inscription.php");
        } elseif ($_GET['action'] === 'user') {
            require("templates/user.php");
        } elseif ($_GET['action'] === 'sell') {
            require("templates/sellProduct.php");

////////////////////////////// Page Connection/Inscription (creation) //////////////////////////////
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

////////////////////////////// Favoris //////////////////////////////
        } elseif ($_GET['action'] === 'favorite') { // favorite
            if (isset($_GET['id']) && $_GET['id'] >= 0) {
                if (!isset($_SESSION['user'])) {
                    // Utilisateur non connecté
                    http_response_code(401); // optionnel, HTTP Unauthorized
                    echo "not_logged";
                    exit;
                }

                $id_product = $_GET['id'];
                $id_user = $_SESSION['user']['id_user'];

                if (isProductFavorite($id_product, $id_user)) exit;

                $success = setProductFavorite($id_product, $id_user);
                if (!$success) throw new Exception("You can't favorite this product !");
            } else {
                throw new Exception("Les informations pour mettre en favoris l'annonce a échoué !");
            }
        } elseif ($_GET['action'] === 'unfavorite') { // unfavorite
            if (isset($_GET['id']) && $_GET['id'] >= 0) {
                if (!isset($_SESSION['user'])) {
                    // Utilisateur non connecté
                    http_response_code(401); // optionnel, HTTP Unauthorized
                    echo "not_logged";
                    exit;
                }

                $id_product = $_GET['id'];
                $id_user = $_SESSION['user']['id_user'];

                if (!isProductFavorite($id_product, $id_user)) exit;

                $success = unsetProductFavorite($id_product, $id_user);
                if (!$success) throw new Exception("You can't unfavorite this product !");

            } else {
                throw new Exception("Les informations pour enlever en favoris l'annonce a échoué !");
            }

////////////////////////////// Page Produit //////////////////////////////
        } elseif ($_GET['action'] === 'product') {
            if (isset($_GET['id']) && $_GET['id'] >= 0) {
                $p = getProduct($_GET['id']);
                if ($p === false) throw new Exception("This product doesn't exist !");

                $current_price = getLastPrice($p['id_product'])['last_price'];
                isset($_SESSION['user']) ? $isFav = isProductFavorite($_GET['id'], $_SESSION['user']['id_user']) : $isFav = false;

                require("templates/product.php");
            }
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