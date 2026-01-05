<?php

require_once("src/model/pdo.php");

function addNewProduct(int $id_user, array $input)
{
    var_dump($input);
    if (!empty($input["nom_annonce_vente"]) && !empty($input["lst_categorie_vente"]) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['description_produit'])) {
        $title = trim(htmlentities($input['nom_annonce_vente']));
        $category = trim(htmlentities($input['lst_categorie_vente']));
        $start_date = trim(htmlentities($input['date_debut']));
        $end_date = trim(htmlentities($input['date_fin']));
        $description = trim(htmlentities($input['description_produit']));
        if (isset($input['valeur_reserve'])) {
            $reserve_price = trim(htmlentities($input['valeur_reserve']));
        } else {
            $reserve_price = null;
        }
    } else {
        throw new Exception("Les données du formulaire sont invalides !");
    }

    $id_product = createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user);
    if (!$id_product) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        checkImage($id_product);

        header("Location: index.php?action=user");
    }

}

function checkImage($id_annonce){
    try{
        //Verification de la présence d'images
        if (!isset($_FILES['image_produit'])) {
            echo("Erreur : Aucune image sélectionnée.");
            exit();
        }
        // Crée le dossier avec le nom de l'annonce
        $DirAnnonce = __DIR__ . "../../../Annonce/" . $id_annonce;
        
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
                $newFilePath = $DirAnnonce . "/" . $id_annonce . "_" . $i . ".jpg";
                if(move_uploaded_file($tmpFilePath, $newFilePath)){
                    //Ajouter dans un tableau qui sera inséré en base de données
                    $name_image = $id_annonce . "_" . $i. ".jpg";
                    $newFilePath = "Annonce/". $id_annonce . "/" . $name_image;
                    addImage($id_annonce,$newFilePath, $name_image);
                }
            }
        }
        if (isset($_FILES['certificat_autenticite'])) {
            certificat($id_annonce, $DirAnnonce);
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
