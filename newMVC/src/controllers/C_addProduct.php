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

        $title = htmlspecialchars($input['nom_annonce_vente']);
        $category = htmlspecialchars($input['lst_categorie_vente']);
        $start_date = htmlspecialchars($input['date_debut']);
        $end_date = htmlspecialchars($input['date_fin']);
        $description = htmlspecialchars($input['description_produit']);
        $celebrite = htmlspecialchars($input['inputcelebrity']);
        if (isset($input['valeur_reserve'])) {
            $reserve_price = trim(htmlentities($input['valeur_reserve']));
        } else {
            $reserve_price = null;
        }
    } else {
        throw new Exception("Les données du formulaire sont invalides !");
    }

    // Au cas ou nouvelle categorie ou celebrite
    $statut_admin_Categorie = checkCategorie($category, $productRepository) ? 1 : 0;
    $statut_admin_Celebrite = checkCelebrite($celebrite, $CelebrityRepository) ? 1 : 0;

    if ($statut_admin_Celebrite == 0 || $statut_admin_Categorie == 0) {
        $statut = 0;
    } else {
        $statut = 1;
    }

    $id_product = $productRepository->createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user, $statut);

    //Insert categorie
    if ($statut_admin_Categorie == 0) {
        insertCategorie($category, $id_product, $productRepository, $statut_admin_Categorie);
    } else {
        $productRepository->linkCategoryProduct($id_product, $category);
    }

    //Insert Celebrity
    if ($statut_admin_Celebrite == 0) {
        InsertCelebrity($celebrite, $id_product, $CelebrityRepository, $statut_admin_Celebrite);
    } else {
        $CelebrityRepository->linkCelebrityProduct($id_product, $celebrite);
    }

    if (!$id_product) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        checkImage($id_product, $productRepository);
        $user_email = $user['email'];
        $user_name = $user['name'];
        if ($statut == 0) {
            $param = [$user_email, $user_name, $title];
            routeurMailing('sendEmailPendingPlublish', $param);
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

            routeurMailing('productValidationAdmin', $param);
        } else {
            $param = [$user_email, $user_name];
            routeurMailing('sendEmailConfirmationPlublish', $param);
        }
        header("Location: index.php?action=user");
    }

}

function checkImage($id_product, ProductRepository $productRepository)
{
    try {
        //Verification de la présence d'images
        if (!isset($_FILES['image_produit'])) {
            echo ("Erreur : Aucune image sélectionnée.");
            exit();
        }
        // Crée le dossier avec le nom de l'annonce
        $DirAnnonce = __DIR__ . "../../../Annonce/" . $id_product;

        // Vérifie si le dossier existe déjà
        if (!is_dir($DirAnnonce)) {
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
        // Fonction native de php pour déplacer les fichier
        try {
            move_uploaded_file($tmpFilePath, $newFilePath);
        } catch (Exception $e) {
            throw new Exception("Error while moving your certificate file !" . $e->getMessage());
        }
        try {
            saveCertificatePath($id_annonce, $databasePath);
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