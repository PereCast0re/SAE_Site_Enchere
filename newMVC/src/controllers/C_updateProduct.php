<?php

require_once(__DIR__ . '/../lib/database.php');
require_once(__DIR__ . '/../model/product.php');
require_once(__DIR__ . '/../model/celebrity.php');
function UpdateProduct($id_product){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $celebrityRepositiory = new CelebrityRepository($pdo);

}

function UpdateFromProduct($id_product){
    $infoProduct = getInfo($id_product);
    $_SESSION['updateProduct'] = $infoProduct;
    echo '<script>console.log("Update de annonce : -> '.json_encode($infoProduct).'")</script>';
    header('Location: index.php?action=updateProductPage');
    exit();
}

function getInfo($id_product){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $celebrityRepository = new CelebrityRepository($pdo);

    $product = $productRepository->getThisProduct($id_product);
    $categorie = $productRepository->getCategoryFromAnnoncement($id_product);
    $celebrity = $celebrityRepository->getCelebrityFromAnnoncement($id_product);
    $fichiers = $productRepository->getFilesFromAnnoncement($id_product);
    $image = [];
    $certificat = [];
    foreach($fichiers as $file){
        if(strpos($file['path_image'], '.pdf') !== false){
            $certificat[] = $file;
        } else {
            $image[] = $file;
        }
    }

    return ['product' => $product, 'categorie' => $categorie, 'celebrity' => $celebrity, 'file' => $image, 'certificat' => $certificat ];
}

function finalUpdateProduct($user, $input){
    if(isset($input['id_product']) && $input['id_product'] > 0){
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
    $statut_admin_Categorie = updateCheckCategorie($category, $productRepository)? 1 : 0;
    $statut_admin_Celebrite = updateCheckCelebrite($celebrite, $CelebrityRepository)? 1: 0;

    if ($statut_admin_Celebrite == 0 || $statut_admin_Categorie == 0){$statut = 0;} else{ $statut = 1;}

    $id_product = $productRepository->updateProduct($id, $title, $description, $start_date, $end_date, $reserve_price, $statut);
    
    //Insert categorie
    if ($statut_admin_Categorie == 0){
        updateInsertCategorie($category, $id, $productRepository, $statut_admin_Categorie);
    } else{
        $productRepository->updateLinkCategoryProduct($id, $category);
    }

    //Insert Celebrity
    if ($statut_admin_Celebrite == 0){
        updateInsertCelebrity($celebrite, $id, $CelebrityRepository, $statut_admin_Celebrite);
    } else {
        $CelebrityRepository->updateLinkCelebrityProduct($id, $celebrite);
    }

    if (!$id) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        $user_email = $user['email'];
        $user_name = $user['name'];
        $param =[$user_email, $user_name] ;
        routeurMailing('sendEmailConfirmationUpdate', $param);
        header("Location: index.php?action=user");
    }
}

function updateCheckCategorie($saisie, $productRepository){
    $categories = $productRepository->getCategoryMod($saisie);
    if($categories){
        return true;
    }
    else{
        return false;
    }
}

function updateInsertCategorie($categories, $id_product, $productRepository, $statut_admin_Categorie){
    try{
        $productRepository->insertCategorie($categories, $statut_admin_Categorie);
        $productRepository->linkCategoryProduct($id_product, $categories);
    } catch (Exception $e) {
        die("Error en insertion of your categorie" .$e->getMessage());
    }
}

function updateCheckCelebrite($saisie, $CelebrityRepository){
    $celebrite = $CelebrityRepository->getCelebrityMod($saisie);
    if($celebrite){
        return true;
    }
    else{
        return false;
    }
}

function updateInsertCelebrity($celebrite, $id_product, $CelebrityRepository, $statut_admin_Celebrite){
    try{
        $CelebrityRepository->insertCelebrity($celebrite, $statut_admin_Celebrite);
        $CelebrityRepository->linkCelebrityProduct($id_product, $celebrite);
    } catch (Exception $e){
        die('Error on insertion of your celebrity' .$e->getMessage());
    }
}

