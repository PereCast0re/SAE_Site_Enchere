<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\Repositories\ProductRepository;
use App\Model\Repositories\CelebrityRepository;
use App\Model\Repositories\UserRepository;
use Exception;
use App\Model\Repositories\ViewRepository;
use App\Model\Repositories\CommentRepository;
use App\Model\Repositories\FavoriteRepository;
use App\Controllers\NotificationsController;

class ProductController
{
    private NotificationsController $notificationsController;

    public function __construct()
    {
        $this->notificationsController = new NotificationsController();
    }

    function addNewProduct($user, $input)
    {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $CelebrityRepository = new CelebrityRepository($pdo);

        // var_dump($user);
        $id_user = $user['id_user'];
        // var_dump($input);
        if (!empty($input["nom_annonce_vente"]) && !empty($input["lst_categorie_vente"]) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['description_produit'])) {
            // $title = trim(htmlentities($input['nom_annonce_vente']));
            // $category = trim(htmlentities($input['lst_categorie_vente']));
            // $start_date = trim(htmlentities($input['date_debut']));
            // $end_date = trim(htmlentities($input['date_fin']));
            // $description = trim(htmlentities($input['description_produit']));
            // $celebrite = trim(htmlentities($input['inputcelebrity']));

            // Ne pas remettre de html_entities ou htmlchars, on ne sauvegarde pas des données filtrées dans la base,
            // seulement au retour que les données doivent être filtrées à l'affichage
            $title = trim($input['nom_annonce_vente']);
            $category = trim($input['lst_categorie_vente']);
            $start_date = trim($input['date_debut']);
            $end_date = trim($input['date_fin']);
            $description = trim($input['description_produit']);
            $celebrite = trim($input['inputcelebrity']);
            if (isset($input['valeur_reserve'])) {
                $reserve_price = trim(htmlentities($input['valeur_reserve']));
            } else {
                $reserve_price = null;
            }
        } else {
            throw new Exception("Les données du formulaire sont invalides !");
        }

        // Au cas ou nouvelle categorie ou celebrite
        $statut_admin_Categorie = $this->checkCategorie($category, $productRepository) ? 1 : 0;
        $statut_admin_Celebrite = $this->checkCelebrite($celebrite, $CelebrityRepository) ? 1 : 0;

        if ($statut_admin_Celebrite == 0 || $statut_admin_Categorie == 0) {
            $statut = 0;
        } else {
            $statut = 1;
        }

        $id_product = $productRepository->createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user, $statut);

        //Insert categorie
        if ($statut_admin_Categorie == 0) {
            $this->insertCategorie($category, $id_product, $productRepository, $statut_admin_Categorie);
        } else {
            $productRepository->linkCategoryProduct($id_product, $category);
        }

        //Insert Celebrity
        if ($statut_admin_Celebrite == 0) {
            $this->InsertCelebrity($celebrite, $id_product, $CelebrityRepository, $statut_admin_Celebrite);
        } else {
            $CelebrityRepository->linkCelebrityProduct($id_product, $celebrite);
        }

        if (!$id_product) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {
            $this->checkImage($id_product, $productRepository);
            $user_email = $user['email'];
            $user_name = $user['name'];
            if ($statut == 0) {
                $param = [$user_email, $user_name, $title];
                $this->notificationsController->routeurMailing('sendEmailPendingPlublish', $param);
                //Mail aux admin pour validation
                $pdo = DatabaseConnection::getConnection();
                $userRepository = new UserRepository($pdo);
                $Admins = $userRepository->getAdmin();
                if (count($Admins) > 1) {
                    $admin_choosen = $Admins[array_rand($Admins)];
                } else {
                    $admin_choosen = $Admins[0];
                }
                $param = [$admin_choosen['email'], $admin_choosen['name'] . ' ' . $admin_choosen['firstname']];

                $this->notificationsController->routeurMailing('productValidationAdmin', $param);
            } else {
                $param = [$user_email, $user_name];
                $this->notificationsController->routeurMailing('sendEmailConfirmationPlublish', $param);
            }
            header("Location: index.php?action=user");
        }

    }

    function checkImage($id_product, ProductRepository $productRepository)
    {
        try {
            //Verification de la présence d'images
            if (!isset($_FILES['image_produit'])) {
                throw new Exception("Erreur : Aucune image sélectionnée.");
            }
            // Crée le dossier avec le nom de l'annonce
            $DirAnnonce = __DIR__ . "../../../Annonce/" . $id_product;

            // if (!is_dir($DirAnnonce)) {

            // Vérifie si le dossier existe déjà
            if (!file_exists($DirAnnonce)) {
                //creation du dossier
                mkdir($DirAnnonce, 0777, true);
            }

            // Ajoute les images dans le dossier
            for ($i = 0; $i < count($_FILES["image_produit"]['name']); $i++) {
                $tmpFilePath = $_FILES['image_produit']['tmp_name'][$i];
                if ($tmpFilePath != "") {
                    $newFilePath = $DirAnnonce . "/" . $id_product . "_" . $i . ".jpg";
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        //Ajouter dans un tableau qui sera inséré en base de données
                        $name_image = $id_product . "_" . $i . ".jpg";
                        $newFilePath = "Annonce/" . $id_product . "/" . $name_image;
                        $productRepository->addImage($id_product, $newFilePath, $name_image);
                    }
                }
            }
            if (isset($_FILES['certificat_autenticite'])) {
                $this->certificat($id_product, $DirAnnonce, $productRepository);
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout des images : " . $e->getMessage());
        }
    }

    function certificat($id_annonce, $DirAnnonce, ProductRepository $productRepository)
    {
        $tmpFilePath = $_FILES['certificat_autenticite']['tmp_name'];
        if ($tmpFilePath != "") {
            $newFilePath = $DirAnnonce . "/" . $id_annonce . "_Certificate" . ".pdf";
            $databasePath = "Annonce/" . $id_annonce . "/" . $id_annonce . "_Certificate" . ".pdf";
            // Fonction native de php pour déplacer les fichier
            try {
                move_uploaded_file($tmpFilePath, $newFilePath);
            } catch (Exception $e) {
                throw new Exception("Error while moving your certificate file !" . $e->getMessage());
            }
            try {
                $productRepository->saveCertificatePath($id_annonce, $databasePath);
            } catch (Exception $e) {
                throw new Exception("Error while saving your certificate path in database !" . $e->getMessage());
            }
        }
    }

    function checkCategorie($saisie, $productRepository)
    {
        $categories = $productRepository->getCategoryMod($saisie);
        if ($categories) {
            return true;
        } else {
            return false;
        }
    }

    function insertCategorie($categories, $id_product, $productRepository, $statut_admin_Categorie)
    {
        try {
            $productRepository->insertCategorie($categories, $statut_admin_Categorie);
            $productRepository->linkCategoryProduct($id_product, $categories);
        } catch (Exception $e) {
            die("Error en insertion of your categorie" . $e->getMessage());
        }
    }

    function checkCelebrite($saisie, $CelebrityRepository)
    {
        $celebrite = $CelebrityRepository->getCelebrityMod($saisie);
        if ($celebrite) {
            return true;
        } else {
            return false;
        }
    }

    function InsertCelebrity($celebrite, $id_product, $CelebrityRepository, $statut_admin_Celebrite)
    {
        try {
            $CelebrityRepository->insertCelebrity($celebrite, $statut_admin_Celebrite);
            $CelebrityRepository->linkCelebrityProduct($id_product, $celebrite);
        } catch (Exception $e) {
            die('Error on insertion of your celebrity' . $e->getMessage());
        }
    }

    function deleteProductAdmin($id_product, $email_user, $username_user)
    {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $celebrityRepositiory = new CelebrityRepository($pdo);

        // Récupération titre 
        $product = $productRepository->getProduct($id_product);
        $title = $product->product->title;

        //Recupération avant suppression de l'annonce
        $categoryName = $productRepository->getCategoryFromAnnoncement($id_product);
        $celebrityName = $celebrityRepositiory->getCelebrityFromAnnoncement($id_product);

        //Annonce
        $productRepository->deleteProduct($id_product);

        //Cateogrie
        $productRepository->deleteCategory($id_product, $categoryName['name']);

        //Celebrity
        $celebrityRepositiory->deleteCelebrity($id_product, $celebrityName->name);

        // email / nom / title
        $param = [$email_user, $username_user, $title];

        $notificationsController = new NotificationsController();
        $notificationsController->routeurMailing('refusalProductUser', $param);
    }

    function AddNewView($annoncement)
    {
        // bloque les bots (aidé car aucune connaissance sur ce sujet)
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $pdo = DatabaseConnection::getConnection();
        $viewRepository = new ViewRepository($pdo);

        if (
            empty($user_agent) || strlen($user_agent) < 10 ||
            preg_match('/bot|crawl|spider|wget|curl/i', $user_agent)
        ) {
            return false; // Bot détecté, on sort
        }

        // verification délais de 1 min par cookie
        $cookie_name = "viewed_" . $annoncement->id_product;
        // si deja vue recemment 
        if (isset($_COOKIE[$cookie_name])) {
            return false;
        }

        // verification délais de 1min par ip
        $last_view = $viewRepository->getLastViewVerifBot($annoncement->id_product);
        if ($last_view && (time() - strtotime($last_view['view_date']) < 60)) {
            return false;
        }

        // ajout de la vue
        $now = date('Y-m-d H:i:s');
        $tabview = $viewRepository->getViewProduct($annoncement->id_product, $now);

        if (empty($tabview)) {
            $viewRepository->InsertNewView($annoncement->id_product, $now);
        } else {
            $viewRepository->UpdateNumberView($annoncement->id_product);
        }

        // met dans les cookies pour 10 minutes
        setcookie($cookie_name, '1', time() + 600, '/');

        return true;
    }

    function Product($id_product)
    {
        if (isset($id_product) && $id_product >= 0) {
            $pdo = DatabaseConnection::getConnection();
            $productRepository = new ProductRepository($pdo);
            $data = $productRepository->getProduct($id_product);

            $p = $data->product;
            $c = $data->celebrity;
            $u = $data->user;

            $this->AddNewView($p);

            $commentRepository = new CommentRepository($pdo);
            $comments = $commentRepository->getCommentsFromProduct($id_product);

            $category = $productRepository->getCategoryFromAnnoncement($id_product);
            // var_dump($category);
            $current_price = $productRepository->getLastPrice($p->id_product)['last_price'];
            if ($current_price === null) {
                $current_price = $p->start_price;
            }

            $reservePrice = (int) $p->reserve_price;
            // var_dump($reservePrice);

            $userRepository = new UserRepository($pdo);
            $images = $userRepository->getImage($id_product);

            $extensions_valides = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            $images = array_filter($images, function ($img) use ($extensions_valides) {
                $ext = strtolower(pathinfo($img['url_image'], PATHINFO_EXTENSION));
                return in_array($ext, $extensions_valides);
            });

            $certificate = array_filter($images, function ($img) {
                $ext = strtolower(pathinfo($img['url_image'], PATHINFO_EXTENSION));
                return $ext === "pdf";
            });

            $certificate = array_values($certificate);

            $favoriteRepository = new FavoriteRepository($pdo);
            $like = $favoriteRepository->getLikes($id_product)['nbLike'];
            if ($like === null) {
                $like = 0;
            }
            isset($_SESSION['user']) ? $isFav = $favoriteRepository->isProductFavorite($id_product, $_SESSION['user']['id_user']) : $isFav = false;

            $price_ex = [];
            for ($i = 0; $i < 3; $i++) {
                array_push($price_ex, $i == 0 ? $current_price + $this->addToPrice($current_price) : $price_ex[$i - 1] + $this->addToPrice($price_ex[$i - 1]));
            }

            require("templates/product.php");
        }
    }

    function addToPrice($currentPrice)
    {
        if ($currentPrice < 100)
            return 5;
        else if ($currentPrice < 500)
            return 10;
        else if ($currentPrice < 1000)
            return 20;
        else if ($currentPrice < 5000)
            return 50;
        else if ($currentPrice < 10000)
            return 100;
        else if ($currentPrice < 50000)
            return 500;
        return 1000;
    }

    function republishAnnoncement($id_product)
    {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $old_anoncement = $productRepository->getProduct($id_product);

        //$start = new DateTime($old_anoncement['end_date']);
        //$finish = new DateTime($old_anoncement['start_date']);
        //$intervale = $start->diff($finish);

        //$newStart = new DateTime();
        //$nextFinish = clone $newStart;
        //$nextFinish->add(new DateInterval('P' . $intervale->days . 'D'));

        //republishDatabase($old_anoncement['id_product'], $old_anoncement['title'], $old_anoncement['description'], $newStart, $nextFinish, $old_anoncement['reserve_price'], $old_anoncement['start_price'], $old_anoncement['status'], $old_anoncement['start_date'] );
    }

    function acceptReservedPrice($data, $id_user)
    {
        if (isset($data['id_product'])) {
            $id_product = $data['id_product'];

            $pdo = DatabaseConnection::getConnection();
            $productRepository = new ProductRepository($pdo);
            $succes = $productRepository->updateReservePrice($id_product);
            if ($succes) {
                $product = $productRepository->getProduct($id_product);
                // 0
                $email = $id_user['email'];
                // 1 name
                $name = $id_user['name'] . ' ' . $id_user['firstname'];
                // 2
                $titleProduct = $product['title'];
                // 3 name buyer
                $buyer = $productRepository->getBuyer($id_product);
                $nameBuyer = $buyer['name'] . ' ' . $buyer['firstname'];
                // 4 email buyer 
                $emailBuyer = $buyer['email'];

                $paramSeller = [$email, $name, $titleProduct, $nameBuyer, $emailBuyer];
                $paramBuyer = [$emailBuyer, $nameBuyer, $titleProduct];
                $this->notificationsController->routeurMailing('acceptReservedPrice', $paramSeller);
                $this->notificationsController->routeurMailing('acceptReservedBuyer', $paramBuyer);
            }
        } else {
            throw new Exception("ID de produit invalide pour accepter le prix réservé.");
        }
    }

    function refuseReservedPrice($data)
    {
        if (isset($data['id_product'])) {
            $id_product = $data['id_product'];

            $pdo = DatabaseConnection::getConnection();
            $productRepository = new ProductRepository($pdo);
            $userRepository = new UserRepository($pdo);
            $succes = $productRepository->updateReservePrice($id_product);
            $prd = $productRepository->getProduct($id_product);
            if ($succes) {
                $user = $productRepository->get_Specific_Annonce_User($id_product);
                // 0
                $email = $user['email'];
                // 1 name
                $name = $user['seller_name'] . ' ' . $user['seller_firstname'];
                // 2
                $titleProduct = $prd['title'];

                $paramSeller = [$email, $name, $titleProduct];
                $this->notificationsController->routeurMailing('refuseReservedPrice', $paramSeller);
            }
        } else {
            throw new Exception("ID de produit invalide pour refuser le prix réservé.");
        }
    }

    function UpdateProduct($id_product)
    {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $celebrityRepositiory = new CelebrityRepository($pdo);

    }

    function UpdateFromProduct($id_product)
    {
        $infoProduct = $this->getInfo($id_product);
        $_SESSION['updateProduct'] = $infoProduct;
        // echo '<script>console.log("Update de annonce : -> ' . json_encode($infoProduct) . '")</script>';
        header('Location: index.php?action=updateProductPage');
        exit();
    }

    function getInfo($id_product)
    {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $celebrityRepository = new CelebrityRepository($pdo);

        $product = $productRepository->getThisProduct($id_product);
        $categorie = $productRepository->getCategoryFromAnnoncement($id_product);
        $celebrity = $celebrityRepository->getCelebrityFromAnnoncement($id_product);
        $fichiers = $productRepository->getFilesFromAnnoncement($id_product);
        $image = [];
        $certificat = [];
        foreach ($fichiers as $file) {
            if (strpos($file['path_image'], '.pdf') !== false) {
                $certificat[] = $file;
            } else {
                $image[] = $file;
            }
        }

        return ['product' => $product, 'categorie' => $categorie, 'celebrity' => $celebrity, 'file' => $image, 'certificat' => $certificat];
    }

    function finalUpdateProduct($user, $input)
    {
        if (isset($input['id_product']) && $input['id_product'] > 0) {
            $id_product = $input['id_product'];
        } else {
            throw new Exception("L'identifiant du produit est invalide !");
        }

        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $CelebrityRepository = new CelebrityRepository($pdo);
        $id_user = $user['id_user'];

        if (!empty($input["nom_annonce_vente"]) && !empty($input["lst_categorie_vente"]) && !empty($input['date_debut']) && !empty($input['date_fin']) && !empty($input['description_produit']) && !empty($input['id_product'])) {
            $title = trim(htmlentities($input['nom_annonce_vente']));
            $category = trim(htmlentities($input['lst_categorie_vente']));
            $start_date = trim(htmlentities($input['date_debut']));
            $end_date = trim(htmlentities($input['date_fin']));
            $description = trim(htmlentities($input['description_produit']));
            $id = trim(htmlentities($input['id_product']));
            $celebrite = trim(htmlentities($input['inputcelebrity']));
            if (isset($input['valeur_reserve'])) {
                $reserve_price = trim(htmlentities($input['valeur_reserve']));
            } else {
                $reserve_price = null;
            }
        } else {
            throw new Exception("Les données du formulaire sont invalides !");
        }

        // Au cas ou nouvelle categorie ou celebrite
        $statut_admin_Categorie = $this->updateCheckCategorie($category, $productRepository) ? 1 : 0;
        $statut_admin_Celebrite = $this->updateCheckCelebrite($celebrite, $CelebrityRepository) ? 1 : 0;

        if ($statut_admin_Celebrite == 0 || $statut_admin_Categorie == 0) {
            $statut = 0;
        } else {
            $statut = 1;
        }

        $id_product = $productRepository->updateProduct($id, $title, $description, $start_date, $end_date, $reserve_price, $statut);

        //Insert categorie
        if ($statut_admin_Categorie == 0) {
            $this->updateInsertCategorie($category, $id, $productRepository, $statut_admin_Categorie);
        } else {
            $productRepository->updateLinkCategoryProduct($id, $category);
        }

        //Insert Celebrity
        if ($statut_admin_Celebrite == 0) {
            $this->updateInsertCelebrity($celebrite, $id, $CelebrityRepository, $statut_admin_Celebrite);
        } else {
            $CelebrityRepository->updateLinkCelebrityProduct($id, $celebrite);
        }

        if (!$id) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {
            $user_email = $user['email'];
            $user_name = $user['name'];
            $param = [$user_email, $user_name];
            $this->notificationsController->routeurMailing('sendEmailConfirmationUpdate', $param);
            header("Location: index.php?action=user");
        }
    }

    function updateCheckCategorie($saisie, $productRepository)
    {
        $categories = $productRepository->getCategoryMod($saisie);
        if ($categories) {
            return true;
        } else {
            return false;
        }
    }

    function updateInsertCategorie($categories, $id_product, $productRepository, $statut_admin_Categorie)
    {
        try {
            $productRepository->insertCategorie($categories, $statut_admin_Categorie);
            $productRepository->linkCategoryProduct($id_product, $categories);
        } catch (Exception $e) {
            die("Error en insertion of your categorie" . $e->getMessage());
        }
    }

    function updateCheckCelebrite($saisie, $CelebrityRepository)
    {
        $celebrite = $CelebrityRepository->getCelebrityMod($saisie);
        if ($celebrite) {
            return true;
        } else {
            return false;
        }
    }

    function updateInsertCelebrity($celebrite, $id_product, $CelebrityRepository, $statut_admin_Celebrite)
    {
        try {
            $CelebrityRepository->insertCelebrity($celebrite, $statut_admin_Celebrite);
            $CelebrityRepository->linkCelebrityProduct($id_product, $celebrite);
        } catch (Exception $e) {
            die('Error on insertion of your celebrity' . $e->getMessage());
        }
    }
}