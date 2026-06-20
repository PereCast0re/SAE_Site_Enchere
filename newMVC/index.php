<?php

date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/vendor/autoload.php';

session_start();

use App\Controllers\BidController;
use App\Controllers\CommentController;
use App\Controllers\ConnectionController;
use App\Controllers\FavoriteController;
use App\Controllers\MainController;
use App\Controllers\NotificationsController;
use App\Controllers\ProductController;
use App\controllers\UserController;

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;
use App\Model\Repositories\ProductRepository;
use App\Model\Repositories\CelebrityRepository;
use App\Model\Repositories\MailjetRepository;
use App\Model\ProductDetails;

use App\Router\Router;

try {
    $bidController = new BidController();
    $userController = new UserController();
    $connectionController = new ConnectionController();
    $notificationsController = new NotificationsController();
    $productController = new ProductController();
    $commentController = new CommentController();
    $favoriteController = new FavoriteController();

    // Router retrovué nativement sur Laravel et Symfony
    // $router = new Router($_GET['url']);

    // $router->get('/', function () {
    //     echo ("Home");
    // });

    // $router->get('/posts', function () {
    //     echo ("Test 1");
    // });

    // Mettre code spécifique avant les autres génériques car sinon peut être non détecté
    // $router->get('/posts/:id-:slug', function ($id, $slug) use ($router) {
    //     echo $router->url('posts.show', ['id' => 1, 'slug' => 'salut-les-gens']);
    // }, 'posts.show')->width('id', '[0-9]+')->width('slug', '[a-z\-0-9]+');

    // $router->get('/posts/:id', "Main#test");

    // $router->run();

    if (isset($_GET['action']) && $_GET['action'] !== '') {
        ////////////////////////////// Pages //////////////////////////////
        if ($_GET['action'] === 'connection') {
            $_SESSION['show_login_modal'] = true;
            header("Location: index.php");
            exit();
        } elseif ($_GET['action'] === 'deconnexion') {
            $connectionController->disconnection();
        } elseif ($_GET['action'] === 'inscription') {
            $_SESSION['show_register_modal'] = true;
            header('Location: index.php');
            exit;


        } elseif ($_GET['action'] === 'user') {
            $userController->userProfil();
        } elseif ($_GET['action'] === 'sell') {
            require("templates/sellProduct.php");
        } elseif ($_GET['action'] === 'buy') {
            require("templates/buy.php");
        } elseif ($_GET['action'] === 'historique_annonces_publiees') {
            require("templates/historique_annonces_publiees.php");


            ////////////////////////////// Page Connection/Inscription (creation) //////////////////////////////
        } elseif ($_GET['action'] === 'userConnection') {
            $connectionController->userConnection($_POST);
        } elseif ($_GET['action'] === 'userInscription') {
            $userController->inscription($_POST);


        } elseif ($_GET['action'] === 'update_email') {
            $userController->updateEmail($_POST['email']);
        } elseif ($_GET['action'] === 'update_address') {
            $userController->updateAddress($_POST);
        } elseif ($_GET['action'] === 'update_password') {
            $userController->updatePassword($_POST['new_password_2']);
        } elseif ($_GET['action'] === 'update_Firstname') {
            $userController->updateFirstname($_POST);
        } elseif ($_GET["action"] === 'update_Name') {
            $userController->updateName($_POST);

        } elseif ($_GET['action'] === 'newsletter') {
            $_SESSION['show_newsletter_modal'] = true;
            header('Location: index.php');
            exit;
        } elseif ($_GET['action'] === 'subscribeNewsletter') {
            $user = $_SESSION['user'];
            $pdo = DatabaseConnection::getConnection();
            $mailjetRepository = new MailjetRepository($pdo);
            $mailjetRepository->subscribeNewsletter($user['email']);
            $_SESSION['success'] = "Abonnement confirmé 🎉";
            $notificationsController->routeurMailing('subscriptionNewsletter', [$user['email'], $user['name'] . ' ' . $user['firstname']]);
            header('Location: index.php');
            exit;
        } elseif ($_GET['action'] === 'addProduct') {
            $user = $_SESSION['user'];
            $productController->addNewProduct($user, $_POST);

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
                $title = $product->product->title;
                $param = [$_SESSION['user']['email'], $name, $title];
                $notificationsController->routeurMailing('acceptProductUser', $param);
                //header("Location: admin_pannel.php");
                //exit();
            } else {
                throw new Exception("Impossible to update product statut !");
            }

        } elseif ($_GET['action'] === 'updateProduct') {
            if (isset($_POST['id_product']) && $_POST['id_product'] >= 0) {
                $productController->UpdateFromProduct($_POST['id_product']);
            } else {
                throw new Exception("Impossible de modifier ce produit !");
            }


        } elseif ($_GET['action'] == 'updateProductPage') {
            require('templates/updateProduct.php');

        } elseif ($_GET['action'] === 'finalUpdateProduct') {
            $user = $_SESSION['user'];
            $productController->finalUpdateProduct($user, $_POST);

        } elseif ($_GET['action'] === 'addComment') {
            $commentController->addComment();

            ////////////////////////////// Favoris //////////////////////////////
        } elseif ($_GET['action'] === 'favorite') { // favorite
            $favoriteController->favorite();
        } elseif ($_GET['action'] === 'unfavorite') { // unfavorite
            $favoriteController->unfavorite();
        } elseif ($_GET['action'] === 'LisAnnoncementLike') {
            if (isset($_GET['id_user'])) {
                $id = $_GET['id_user'];
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $data = $productRepository->getAllProductLike($id);
                header('Content-Type: application/json');
                echo json_encode($data);
                exit();
            }
        } elseif ($_GET['action'] === 'AnnoncementLike') {
            if (isset($_GET['id_product'])) {
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
            $bidController->bid();


            ////////////////////////////// Page Produit //////////////////////////////
        } elseif ($_GET['action'] === 'product') {
            $productController->Product(id_product: $_GET['id']);

            // A supprimer une fois le style de la effectué
            // $errorMessage = '<i class="fa-solid fa-hammer"></i>  <span>Désolé</span> En cours de développement ! Réessayez ultérieurement !';
            // require('templates/preset/error.php');

        } elseif ($_GET['action'] == 'getComments') {
            $commentController->getComments();

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
                    $pdo = DatabaseConnection::getConnection();
                    $userRepository = new UserRepository($pdo);
                    $global_views = $userRepository->getGlobalViews($id_product);
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
                $pdo = DatabaseConnection::getConnection();
                $userRepository = new UserRepository($pdo);
                $likes = $userRepository->getLikes($id_product);
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
                $pdo = DatabaseConnection::getConnection();
                $userRepository = new UserRepository($pdo);
                $image = $userRepository->getImage($id_product);
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
                $pdo = DatabaseConnection::getConnection();
                $userRepository = new UserRepository($pdo);
                $annoncements = $userRepository->getAnnoncementEndWithReservedPrice($id_user);
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
                $pdo = DatabaseConnection::getConnection();
                $userRepository = new UserRepository($pdo);
                $annoncements = $userRepository->getListFinishedAnnoncements($id_user);
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
                $productController->republishAnnoncement($id_product);
            } else {
                throw new Exception("Impossible de re-publée l'annonce");
            }

        } elseif ($_GET['action'] == 'getCelebrityFromProduct') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $pdo = DatabaseConnection::getConnection();
                $celebrityRepository = new CelebrityRepository($pdo);
                $celebrity = $celebrityRepository->getCelebrityFromAnnoncement($id_product);
                if ($celebrity !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($celebrity);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer la célébrité associée à ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer la célébrité.");
            }

        } elseif ($_GET['action'] == 'getCategoryFromProduct') {
            if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
                $id_product = $_GET['id_product'];
                $pdo = DatabaseConnection::getConnection();
                $productRepository = new ProductRepository($pdo);
                $category = $productRepository->getCategoryFromAnnoncement($id_product);
                if ($category !== false) {
                    header('Content-Type: application/json');
                    echo json_encode($category);
                    exit();
                } else {
                    throw new Exception("Impossible de récupérer la catégorie associée à ce produit.");
                }
            } else {
                throw new Exception("ID de produit invalide pour récupérer la catégorie.");
            }

        } elseif ($_GET['action'] == 'acceptReservedPrice') {
            $productController->acceptReservedPrice($_POST, $_SESSION['user']['id_user']);

        } elseif ($_GET['action'] == 'refuseReservedPrice') {
            $productController->refuseReservedPrice($_POST);

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
            $notificationsController->PostNewsletter($_POST);

        } elseif ($_GET['action'] === 'deleteProductAdmin') {
            if (isset($_POST['id_product']) && $_POST['id_product'] >= 0) {
                $productController->deleteProductAdmin($_POST['id_product'], $_SESSION['user']['email'], $_SESSION['user']['username']);
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

    //$errorMessage = '<i class="fa-solid fa-bug"></i> <span>Erreur 404 :</span> Page non trouvé !';

    // require('templates/preset/error.php');
}