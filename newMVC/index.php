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
require_once('src/controllers/C_republishAnnoncement.php');
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
        } elseif ($_GET['action'] === 'buy') {
            require("templates/buy.php");

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
        } elseif ($_GET['action'] === 'historique_annonces_publiees') {
            require("templates/historique_annonces_publiees.php");
            
        //  addNewProduct($id_user, $_POST);

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

                favorite($id_product, $id_user);
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

                unfavorite($id_product, $id_user);
            } else {
                throw new Exception("Les informations pour enlever en favoris l'annonce a échoué !");
            }
        ////////////////////////////// Bid //////////////////////////////
        } elseif ($_GET['action'] === 'bid') {
            if (isset($_GET['id']) && $_GET['id'] >= 0) {
                if (!isset($_SESSION['user'])) {
                    // Utilisateur non connecté
                    http_response_code(401); // optionnel, HTTP Unauthorized
                    echo "not_logged";
                    exit;
                }

                $id_product = $_GET['id'];
                $id_user = $_SESSION['user']['id_user'];
                $newPrice = (int)$_POST['newPrice'];
                
                bid($id_product, $id_user, $newPrice);
            }


        ////////////////////////////// Page Produit //////////////////////////////
        } elseif ($_GET['action'] === 'product') {
            Product(id_product: $_GET['id']);
        
        ////////////////////////////// page user //////////////////////////////
        // get price
        } elseif ($_GET['action'] === 'getLastPrice') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $last_price = getLastPrice($id_product);
                if ($last_price !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($last_price);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer le dernier prix pour ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer le dernier prix.");
            }
        // Daily views
        } elseif ($_GET['action'] === 'getDailyViews') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $daily_views = getDailyViews($id_product);
                if ($daily_views !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($daily_views);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer les vues journalières pour ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer les vues journalières.");
            }

        // Global views
        } elseif ($_GET['action'] === 'getGlobalViews') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $global_views = getGlobalViews($id_product);
                if ($global_views !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($global_views);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer les vues globales pour ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer les vues globales.");
            }

        // Likes
        } elseif ($_GET['action'] === 'getLikes') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $likes = getLikes($id_product);
                if ($likes !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($likes);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer les likes pour ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer les likes.");
            }

        // Image
        } elseif ($_GET['action'] === 'getImage') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0 && isset($_GET['title'])) {
                $id_product = $_GET['id_product'];
                $title = $_GET['title'] ."_0";
                $image = getImage($id_product, $title);
                if ($image !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($image);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer l'image pour ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer l'image.");
            }

        // Annonce with a reserved price not reached and finished
        } elseif ($_GET['action'] == 'reservedAnnoncement'){
            if (isset($_GET['id_user']) && $_GET['id_user'] >= 0){
                $id_user = $_GET['id_user'];
                $annoncements = getAnnoncementEndWithReservedPrice($id_user);
                if($annoncements !== false){
                    header('Content-Type: application/json');
                    echo json_encode($annoncements);
                    exit();
                } else {
                    throw new Exception("Impossible d'extraire des annonce finis avec un prix de réserve.");
                }
            } else {
                throw new Exception("Impossible de récupéré l'indice utilisateur");
            }

        // List of finish annoncement
        } elseif ($_GET['action'] == 'LisAnnoncementEnd'){
            if (isset($_GET['id_user']) && $_GET['id_user'] >= 0){
                $id_user = $_GET['id_user'];
                $annoncements = getListFinishedAnnoncements($id_user);
                if($annoncements !== false){
                    header('Content-Type: application/json');
                    echo json_encode($annoncements);
                    exit();
                } else {
                    throw new Exception("Impossible d'extraire des annonce finis.");
                }
            } else {
                throw new Exception("Impossible de récupéré l'indice utilisateur");
            }

        } elseif ($_GET['action'] == 'republish'){
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0){
                $id_product = $_GET['id_product'];
                republishAnnoncement($id_product);
            } else {
                throw new Exception("Impossible de re-publée l'annonce");
            }

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