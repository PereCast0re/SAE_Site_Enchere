<?php

session_start();

require_once('src/controllers/C_addProduct.php');
require_once('src/controllers/C_connection.php');
require_once('src/controllers/C_inscription.php');
require_once('src/controllers/C_pageProduct.php');
require_once('src/controllers/C_pageUser.php');
require_once('src/controllers/C_updateUser.php');
require_once('src/controllers/C_favorite.php');
require_once('src/controllers/C_unfavorite.php');
require_once('src/controllers/C_bid.php');
require_once('src/controllers/C_addComment.php');
require_once("src/model/pdo.php");

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        ////////////////////////////// Pages //////////////////////////////
        if ($_GET['action'] === 'connection') {
            require("templates/connection.php");
        } elseif ($_GET['action'] === 'inscription') {
            require("templates/inscription.php");
        } elseif ($_GET['action'] === 'user') {
            if (isset($_GET['id']) && $_GET['id'] >= 0) {
                $score = getRatingUser($_GET['id']);
                $score == null ? $score = 0 : $score;
                $u = getUser($_GET['id']);
                require("templates/userProfil.php");
            } else {
                require("templates/user.php");
            }
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
            addNewProduct($id_user, $_POST);
        } elseif ($_GET['action'] === 'addComment') {
            addComment();


            ////////////////////////////// Favoris //////////////////////////////
        } elseif ($_GET['action'] === 'favorite') { // favorite
            favorite();
        } elseif ($_GET['action'] === 'unfavorite') { // unfavorite
            unfavorite();


            ////////////////////////////// Bid //////////////////////////////
        } elseif ($_GET['action'] === 'bid') {
            bid();


            ////////////////////////////// Page Produit //////////////////////////////
        } elseif ($_GET['action'] === 'product') {
            Product($_GET['id']);


            ////////////////////////////// Cas de base //////////////////////////////        
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