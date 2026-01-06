<?php

require_once('src/lib/database.php');
require_once('src/model/product.php');
require_once("src/controllers/C_emailing.php");
require_once("src/model/pdo.php");

function addNewProduct($user, $input)
{
    var_dump($user);
    $id_user = $user['id_user'];
    var_dump($input);
    if (!empty($input["nom_annonce_vente"]) && !empty($input["lst_categorie_vente"]) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['description_produit'])) {
        $title = trim(htmlentities($input['nom_annonce_vente']));
        $category = trim(htmlentities($input['lst_categorie_vente']));
        $start_date = trim(htmlentities($input['date_debut']));
        $end_date = trim(htmlentities($input['date_fin']));
        $description = trim(htmlentities($input['description_produit']));
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
    $statut_admin_Categorie = checkCategorie($category)? 1 : 0;
    $statut_admin_Celebrite = checkCelebrite($celebrite);

    if ($statut_admin_Celebrite == 1 && $statut_admin_Categorie == 1){$statut = 1;} else{ $statut = 0;}

    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $id_product = $productRepository->createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user, $statut);
    
    if (!$id_product) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        checkImage($id_product, $productRepository);
        $user_email = $user['email'];
        $user_name = $user['name'];
        $param =[$user_email, $user_name] ;
        routeurMailing('sendEmailConfirmationPlublish', $param);
        header("Location: index.php?action=user");
    }

}

function checkImage($id_product, ProductRepository $productRepository){
    try{
        //Verification de la présence d'images
        if (!isset($_FILES['image_produit'])) {
            echo("Erreur : Aucune image sélectionnée.");
            exit();
        }
        // Crée le dossier avec le nom de l'annonce
        $DirAnnonce = __DIR__ . "../../../Annonce/" . $id_product;
        
        // Vérifie si le dossier existe déjà
        if (!is_dir($DirAnnonce)) {
            //creation du dossier
            mkdir($DirAnnonce, 0777, true);
        } else {
            echo("Erreur : Le dossier existe déjà.");
            exit();
        }
        
        // Ajoute les images dans le dossier
        for ($i = 0; $i < count($_FILES["image_produit"]['name']); $i++) {
            $tmpFilePath = $_FILES['image_produit']['tmp_name'][$i];
            if ($tmpFilePath != ""){
                $newFilePath = $DirAnnonce . "/" . $id_product . "_" . $i . ".jpg";
                if(move_uploaded_file($tmpFilePath, $newFilePath)){
                    //Ajouter dans un tableau qui sera inséré en base de données
                    $name_image = $id_product . "_" . $i. ".jpg";
                    $newFilePath = "Annonce/". $id_product . "/" . $name_image;
                    $productRepository->addImage($id_product,$newFilePath, $name_image);
                }
            }
        }
        if (isset($_FILES['certificat_autenticite'])) {
            certificat($id_product, $DirAnnonce);
        }
    } catch (Exception $e){
        echo("Erreur lors de l'ajout des images : " .$e->getMessage());
        exit();
    }
}

function certificat($id_annonce, $DirAnnonce){
    $tmpFilePath = $_FILES['certificat_autenticite']['tmp_name'];
    if ($tmpFilePath != ""){
        $newFilePath = $DirAnnonce . "/" . $id_annonce . "_Certificate" . ".pdf";
        // Fonction native de php pour déplacer les fichier
        move_uploaded_file($tmpFilePath, $newFilePath);
        saveCertificatePath($id_annonce, $newFilePath);
    }
}

function checkCategorie($saisie){
    $categories = getCategoryMod($saisie);
    if($categories){
        return true;
    }
    else{
        return false;
    }
}

function checkCelebrite($saisie){
    $celebrite = getCelebrityMod($saisie);
    if($celebrite){
        return true;
    }
    else{
        return false;
    }
}