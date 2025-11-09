<?php

session_start();

$user = $_SESSION["user"];

require_once("../Modele/pdo.php");


if (isset($_POST["nom_annonce_vente"]) && isset($_POST["lst_categorie_vente"]) && isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['description_produit'])) {
    $title = $_POST['nom_annonce_vente'];
    $category = $_POST['lst_categorie_vente'];
    $start_date = $_POST['date_debut'];
    $end_date = $_POST['date_fin'];
    $description = $_POST['description_produit'];
    if (isset($_POST['valeur_reserve'])){
        $reserve_price = $_POST['valeur_reserve'];
    }
    else{
        $reserve_price = null;
    }

    /// info user
    $id_user = $user['id_user'];

    try{
        AddProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user);
        // Ajout des images avec création dossier
        try{
            //Verification de la présence d'images
            if (!isset($_FILES['image_produit'])) {
                die("Erreur : Aucune image sélectionnée.");
            }
            
            // Crée le dossier avec le nom de l'annonce
            $DirAnnonce = "../Annonce/" . $nom;

            // Vérifie si le dossier existe déjà
            if (!is_dir($DirAnnonce)) {
                //creation du dossier
                mkdir($DirAnnonce, 0777, true);
            } else {
                die("Erreur : Le dossier existe déjà.");
            }

            // Ajoute les images dans le dossier
            $nbImage = count($_FILES['image_produit']['name']);
            
            for ($i = 0; $i < $nbImage; $i++) {
                $tmpFilePath = $_FILES['image_produit']['tmp_name'][$i];
                if ($tmpFilePath != ""){
                    $newFilePath = $DirAnnonce . "/" . $nom . "_" . $i . ".jpg";
                    // Fonction native de php pour déplacer les fichier
                    move_uploaded_file($tmpFilePath, $newFilePath);
                }
            }

            if (isset($_FILES['certificat_autenticite'])) {
                certificat($nom, $DirAnnonce);
            }

        } catch (Exception $e){
            die("Erreur lors de l'ajout des images : " .$e->getMessage());
        }
        
        //Pour verifié les images passé
        //var_dump($_FILES['image_produit']['tmp_name']);
        header("Location: ../Vue/client.php");

    } catch (Exception $e){
        die("Erreur lors de l'ajout de l'annonce : " .$e->getMessage());
    }
}
else{
    echo('Erreur dans la publication de votre annonce.');
}

function certificat($nom, $DirAnnonce){
    $tmpFilePath = $_FILES['certificat_autenticite']['tmp_name'];
    if ($tmpFilePath != ""){
        $newFilePath = $DirAnnonce . "/" . $nom . "_Certificate" . ".pdf";
        // Fonction native de php pour déplacer les fichier
        move_uploaded_file($tmpFilePath, $newFilePath);
    }
}
