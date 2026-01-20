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
require_once('src/controllers/C_republishAnnoncement.php');
require_once('src/controllers/C_addComment.php');
require_once('src/controllers/C_index.php');
require_once("src/controllers/C_newsletter.php");
require_once('src/controllers/C_deleteProduct.php');
require_once('src/controllers/C_updateProduct.php');
require_once('src/controllers/C_emailing.php');
require_once('src/controllers/C_reservedPrice.php');
require_once('src/controllers/C_getComments.php');

require_once("src/model/pdo.php");
require_once('src/lib/database.php');
require_once('src/model/user.php');
require_once('src/model/celebrity.php');

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        ////////////////////////////// Pages //////////////////////////////
        if ($_GET['action'] === 'connection') {
            $_SESSION['show_login_modal'] = true;
            header("Location: index.php");
            exit();
        } elseif ($_GET['action'] === 'deconnexion') {
            require_once('src/controllers/C_deconnexion.php');
        } elseif ($_GET['action'] === 'inscription') {
            $_SESSION['show_register_modal'] = true;
            header('Location: index.php');
            exit;
        } elseif ($_GET['action'] === 'user') {
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
        } elseif ($_GET['action'] === 'sell') {
            require("templates/sellProduct.php");
        } elseif ($_GET['action'] === 'buy') {
            require("templates/buy.php");
        } elseif ($_GET['action'] === 'historique_annonces_publiees') {
            require("templates/historique_annonces_publiees.php");


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
        }elseif ($_GET['action'] === 'update_Firstname'){
            updateFirstname($_POST);
        } elseif ($_GET["action"] === 'update_Name'){
            updateName($_POST);

        } elseif ($_GET['action'] === 'newsletter') {
            $_SESSION['show_newsletter_modal'] = true;
            header('Location: index.php');
            exit;
        } elseif ($_GET['action'] === 'subscribeNewsletter') {
            $user = $_SESSION['user'];
            subscribeNewsletter($user['email']);
            $_SESSION['success'] = "Abonnement confirmé 🎉";
            routeurMailing('subscriptionNewsletter', [$user['email'], $user['name'] . ' ' . $user['firstname']]);
            header('Location: index.php');
            exit;
        } elseif ($_GET['action'] === 'addProduct') {
            $user = $_SESSION['user'];
            addNewProduct($user, $_POST);

        } elseif ($_GET['action'] === 'deleteProduct') {
            if (isset($_POST['id_product']) && $_POST['id_product'] >= 0) {
                $pdo = DatabaseConnection::getConnection();
                $celebrityRepository = new CelebrityRepository(pdo: $pdo);
                $productRepository = new ProductRepository($pdo);
                $id_product = $_POST['id_product'];
                $success = $productRepository->deleteProduct($id_product);
                if (!$success) {
                    throw new Exception("This product can't be deleted");
                }
            } else {
                throw new Exception("Impossible to delete this product !");
            }

        } elseif ($_GET['action'] === 'validateAnnoncement') {
            if (isset($_POST['id_product']) && $_POST['id_product'] >= 0) {
                $id_product = $_POST['id_product'];
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $celebrityRepository = new CelebrityRepository($pdo);
                $productRepository->UpdateStatut($id_product);
                $productRepository->UpdateStatutCategorie($id_product);
                $celebrityRepository->UpdateStatutCelebrity($id_product);

                $name = $_SESSION['user']['name'] . $_SESSION['user']['firstname'];
                $product = $productRepository->getProduct($id_product);
                $title = $product['title'];
                $param = [$_SESSION['user']['email'], $name, $title];
                routeurMailing('acceptProductUser', $param);
                //header("Location: admin_pannel.php");
                //exit();
            } else {
                throw new Exception("Impossible to update product statut !");
            }

        } elseif ($_GET['action'] === 'updateProduct'){
            if (isset($_POST['id_product']) && $_POST['id_product'] >= 0){
                UpdateFromProduct($_POST['id_product']);
            } else {
                throw new Exception("Impossible de modifier ce produit !" .$e->getMessage());
            }
        

        } elseif ($_GET['action'] == 'updateProductPage'){
            require('templates/updateProduct.php');

        } elseif ($_GET['action'] === 'finalUpdateProduct'){
            $user = $_SESSION['user'];
            finalUpdateProduct($user, $_POST);

        } elseif ($_GET['action'] === 'addComment') {
            addComment();

            ////////////////////////////// Favoris //////////////////////////////
        } elseif ($_GET['action'] === 'favorite') { // favorite
            favorite();
        } elseif ($_GET['action'] === 'unfavorite') { // unfavorite
            unfavorite();
        } elseif ($_GET['action'] === 'LisAnnoncementLike'){
            if(isset($_GET['id_user'])){
                $id = $_GET['id_user'];
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $data = $productRepository->getAllProductLike($id);
                header('Content-Type: application/json');
                echo json_encode($data);
                exit();
            }
        } elseif ($_GET['action'] === 'AnnoncementLike'){
            if(isset($_GET['id_product'])){
                $id = $_GET['id_product'];
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $data = $productRepository->getProduct($id);
                header('Content-Type: application/json');
                echo json_encode($data);
                exit();
            }


            ////////////////////////////// Bid //////////////////////////////
        } elseif ($_GET['action'] === 'bid') {
            bid();


            ////////////////////////////// Page Produit //////////////////////////////
        } elseif ($_GET['action'] === 'product') {
            Product(id_product: $_GET['id']);

            // A supprimer une fois le style de la effectué
            // $errorMessage = '<i class="fa-solid fa-hammer"></i>  <span>Désolé</span> En cours de développement ! Réessayez ultérieurement !';
            // require('templates/preset/error.php');

        } elseif ($_GET['action'] == 'getComments') {
            getComments();

            ////////////////////////////// page user //////////////////////////////
            // get price
        } elseif ($_GET['action'] === 'getLastPrice') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                if (!empty($_GET['option'])) {
                    $id_product = $_GET['id_product'];
                    $option = $_GET['option'];
                    $pdo = DatabaseConnection::getConnection();
                    $productRepository = new ProductRepository($pdo);
                    $data = $productRepository->getPriceWithOption($id_product, $option);
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    exit();
                } else {
                    $id_product = $_GET['id_product'];
                    $pdo = DatabaseConnection::getConnection();
                    $productRepository = new ProductRepository($pdo);
                    $last_price = $productRepository->getLastPrice($id_product);
                    if ($last_price !== false) {
                        header('Content-Type: application/json');
                        echo json_encode($last_price);
                        exit();
                    } else {
                        throw new Exception("Impossible de récupérer le dernier prix pour ce produit.");
                    }
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer le dernier prix.");
            }
            // global views
        } elseif ($_GET['action'] === 'getGlobalViews') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                if (!empty($_GET['option'])) {
                    $id_product = $_GET['id_product'];
                    $option = $_GET['option'];
                    $pdo = DatabaseConnection::getConnection();
                    $productRepository = new ProductRepository($pdo);
                    $data = $productRepository->getViewsWithOption($id_product, $option);
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    exit();
                } else {
                    $id_product = $_GET['id_product'];
                    $global_views = getGlobalViews($id_product);
                    if ($global_views !== false) {
                        header('Content-Type: application/json');
                        echo json_encode($global_views);
                        exit();
                    } else {
                        throw new Exception("Impossible de récupérer les vues globales pour ce produit.");
                    }
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

        } elseif ($_GET['action'] === 'getLikesPage') {
            require_once('templates/like.php');

            // Image
        } elseif ($_GET['action'] === 'getImage') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $image = getImage($id_product);
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
        } elseif ($_GET['action'] == 'reservedAnnoncement') {
            if (isset($_GET['id_user']) && $_GET['id_user'] >= 0) {
                $id_user = $_GET['id_user'];
                $annoncements = getAnnoncementEndWithReservedPrice($id_user);
                if ($annoncements !== false) {
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
        } elseif ($_GET['action'] == 'LisAnnoncementEnd') {
            if (isset($_GET['id_user']) && $_GET['id_user'] >= 0) {
                $id_user = $_GET['id_user'];
                $annoncements = getListFinishedAnnoncements($id_user);
                if ($annoncements !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($annoncements);
                    exit();
                } else {
                    throw new Exception("Impossible d'extraire des annonce finis.");
                }
            } else {
                throw new Exception("Impossible de récupéré l'indice utilisateur");
            }

        } elseif ($_GET['action'] == 'republish') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                republishAnnoncement($id_product);
            } else {
                throw new Exception("Impossible de re-publée l'annonce");
            }
        
        } elseif ($_GET['action'] == 'getCelebrityFromProduct'){
            if(isset($_GET['id_product']) && $_GET['id_product'] >= 0){
                $id_product = $_GET['id_product'];
                $pdo = DatabaseConnection::getConnection();
                $celebrityRepository = new CelebrityRepository($pdo);
                $celebrity = $celebrityRepository->getCelebrityFromAnnoncement($id_product);
                if ($celebrity !== false){
                    header('Content-Type: application/json');
                    echo json_encode($celebrity);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer la célébrité associée à ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer la célébrité.");
            }

        } elseif ($_GET['action'] == 'getCategoryFromProduct'){
            if(isset($_GET['id_product']) && $_GET['id_product'] >= 0){
                $id_product = $_GET['id_product'];
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $category = $productRepository->getCategoryFromAnnoncement($id_product);
                if ($category !== false){
                    header('Content-Type: application/json');
                    echo json_encode($category);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer la catégorie associée à ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer la catégorie.");
            }

        }elseif ($_GET['action'] == 'acceptReservedPrice'){
            acceptReservedPrice($_POST, $_SESSION['user']['id_user']);

        } elseif ($_GET['action'] == 'refuseReservedPrice'){
            refuseReservedPrice($_POST, $_SESSION['user']['id_user']);

            ////////////////////////////// Page sell product ////////////////////////

        } elseif ($_GET['action'] == 'getCategoriesMod') {
            if (isset($_GET['writting'])) {
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $writting = $_GET['writting'];
                $categories = $productRepository->getCategoryMod($writting);
                if ($categories !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($categories);
                    exit();
                }
            }

        } elseif ($_GET['action'] == 'getCelebrityMod') {
            if (isset($_GET['writting'])) {
                $pdo = DatabaseConnection::getConnection();
                $celebrityRepository = new CelebrityRepository($pdo);
                $writting = $_GET['writting'];
                $categories = $celebrityRepository->getCelebrityMod($writting);
                if ($categories !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($categories);
                    exit();
                }
            }

            ///////////////////////////////// Admin ////////////////////////////////
        } elseif ($_GET['action'] == 'admin') {
            require('templates/admin_pannel.php');

        } elseif ($_GET['action'] == 'sendNewsletter') {
            PostNewsletter($_POST);

        } elseif ($_GET['action'] === 'deleteProductAdmin') {
            if (isset($_POST['id_product']) && $_POST['id_product'] >= 0) {
                deleteProductAdmin($_POST['id_product'], $_SESSION['user']['email'], $_SESSION['user']['username']);
            }

            ////////////////////////////// Cas de base //////////////////////////////        
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        // homepage(); Kyllian devra changer parce que les fonctions pdo dans l'index c'est pas bien
        require("templates/index.php");
    }
} catch (Exception $e) {

    $errorMessage = $e->getMessage();

    $errorMessage = '<i class="fa-solid fa-bug"></i> <span>Erreur 404 :</span> Page non trouvé !';

    require('templates/preset/error.php');
}