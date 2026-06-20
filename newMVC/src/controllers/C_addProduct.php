<?php

require_once('src/lib/database.php');
require_once('src/model/product.php');
require_once("src/controllers/C_emailing.php");
require_once("src/model/pdo.php");
require_once('src/model/celebrity.php');
require_once('src/model/user.php');

function addNewProduct($user, $input)
{
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $CelebrityRepository = new CelebrityRepository($pdo);

    $id_user = $user['id_user'];
    
    if (!empty($input["nom_annonce_vente"]) && !empty($input["lst_categorie_vente"]) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['description_produit'])) {
        $title = htmlspecialchars($input['nom_annonce_vente']);
        $category = htmlspecialchars($input['lst_categorie_vente']);
        $start_date = htmlspecialchars($input['date_debut']);
        $end_date = htmlspecialchars($input['date_fin']);
        $description = htmlspecialchars($input['description_produit']);
        $celebrite = htmlspecialchars($input['inputcelebrity']);
        
        $reserve_price = isset($input['valeur_reserve']) ? trim(htmlentities($input['valeur_reserve'])) : null;
    } else {
        throw new Exception("Les données du formulaire sont invalides !");
    }

    $statut_admin_Categorie = checkCategorie($category, $productRepository) ? 1 : 0;
    $statut_admin_Celebrite = checkCelebrite($celebrite, $CelebrityRepository) ? 1 : 0;

    $statut = ($statut_admin_Celebrite == 0 || $statut_admin_Categorie == 0) ? 0 : 1;

    $id_product = $productRepository->createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user, $statut);

    // Insert categorie
    if ($statut_admin_Categorie == 0) {
        insertCategorie($category, $id_product, $productRepository, $statut_admin_Categorie);
    } else {
        $productRepository->linkCategoryProduct($id_product, $category);
    }

    // Insert Celebrity
    if ($statut_admin_Celebrite == 0) {
        InsertCelebrity($celebrite, $id_product, $CelebrityRepository, $statut_admin_Celebrite);
    } else {
        $CelebrityRepository->linkCelebrityProduct($id_product, $celebrite);
    }

    if (!$id_product) {
        throw new Exception('Impossible d\'ajouter le produit !');
    } else {
        checkImage($id_product, $productRepository);
        $user_email = $user['email'];
        $user_name = $user['name'];
        
        if ($statut == 0) {
            $param = [$user_email, $user_name, $title];
            routeurMailing('sendEmailPendingPlublish', $param);
            
            // Mail aux admin pour validation
            $pdo = DatabaseConnection::getConnection();
            $userRepository = new UserRepository($pdo);
            $Admins = $userRepository->getAdmin();
            
            // CORRECTION : Sécurisation de la sélection de l'admin si le tableau est vide ou associatif
            if (!empty($Admins)) {
                $keys = array_keys($Admins);
                $random_key = $keys[array_rand($keys)];
                $admin_choosen = $Admins[$random_key];
            } else {
                // Valeurs de secours si aucun admin n'est trouvé en BDD
                $admin_choosen = ['email' => 'admin@auto-ecole.fr', 'name' => 'Admin', 'firstname' => 'Système'];
            }
            
            $param = [$admin_choosen['email'], $admin_choosen['name'] . ' ' . $admin_choosen['firstname']];
            routeurMailing('productValidationAdmin', $param);
        } else {
            $param = [$user_email, $user_name];
            routeurMailing('sendEmailConfirmationPlublish', $param);
        }
        
        header("Location: index.php?action=user");
        exit(); // Toujours mettre un exit après une redirection header
    }
}

function checkImage($id_product, ProductRepository $productRepository)
{
    try {
        if (!isset($_FILES['image_produit'])) {
            echo ("Erreur : Aucune image sélectionnée.");
            exit();
        }
        
        // CORRECTION : Utilisation de dirname(__DIR__, 2) pour remonter proprement à la racine du projet (/var/www/html)
        $DirAnnonce = dirname(__DIR__, 2) . "/Annonce/" . $id_product;

        if (!file_exists($DirAnnonce)) {
            mkdir($DirAnnonce, 0777, true);
        }

        if (isset($_FILES['image_produit']['name']) && is_array($_FILES['image_produit']['name'])) {
            for ($i = 0; $i < count($_FILES["image_produit"]['name']); $i++) {
                $tmpFilePath = $_FILES['image_produit']['tmp_name'][$i];
                if ($tmpFilePath != "") {
                    $name_image = $id_product . "_" . $i . ".jpg";
                    $newFilePath = $DirAnnonce . "/" . $name_image;
                    
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $databasePath = "Annonce/" . $id_product . "/" . $name_image;
                        $productRepository->addImage($id_product, $databasePath, $name_image);
                    }
                }
            }
        }
        
        if (isset($_FILES['certificat_autenticite']) && $_FILES['certificat_autenticite']['error'] == 0) {
            certificat($id_product, $DirAnnonce);
        }
    } catch (Exception $e) {
        echo ("Erreur lors de l'ajout des images : " . $e->getMessage());
        exit();
    }
}

function certificat($id_annonce, $DirAnnonce)
{
    $tmpFilePath = $_FILES['certificat_autenticite']['tmp_name'];
    if ($tmpFilePath != "") {
        $newFilePath = $DirAnnonce . "/" . $id_annonce . "_Certificate" . ".pdf";
        $databasePath = "Annonce/" . $id_annonce . "/" . $id_annonce . "_Certificate" . ".pdf";
        
        try {
            move_uploaded_file($tmpFilePath, $newFilePath);
        } catch (Exception $e) {
            throw new Exception("Error while moving your certificate file !" . $e->getMessage());
        }
        
        try {
            // S'assurer que cette fonction globale ou méthode existe dans l'arborescence
            if (function_exists('saveCertificatePath')) {
                saveCertificatePath($id_annonce, $databasePath);
            }
        } catch (Exception $e) {
            throw new Exception("Error while saving your certificate path in database !" . $e->getMessage());
        }
    }
}

function checkCategorie($saisie, $productRepository)
{
    $categories = $productRepository->getCategoryMod($saisie);
    return !empty($categories);
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
    return !empty($celebrite);
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