<?php

session_start();

$client = $_SESSION["client"];

require_once("../Modele/pdo.php");


if (isset($_POST["nom_annonce_vente"]) && isset($_POST["lst_categorie_vente"]) && isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['description_produit'])) {
    $nom = $_POST['nom_annonce_vente'];
    $categorie = $_POST['lst_categorie_vente'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $description = $_POST['description_produit'];
    if (isset($_POST['valeur_reserve'])){
        $prix_reserve = $_POST['valeur_reserve'];
    }
    else{
        $prix_reserve = null;
    }

    $prix_actuelle = 0;
    $rate = 0;
    $fini = false;

    /// info client
    $id_client = $client['id_client'];

    $LastIdAnnonce = getLastIdAnnonce();
    $id_annonce = $LastIdAnnonce['last_id'] + 1;
    try{
        ajout_annonce($id_annonce, $nom, $description, $date_debut, $date_fin, $prix_actuelle, $prix_reserve, $rate, $fini, $id_client);
        
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

        } catch (Exception $e){
            die("Erreur lors de l'ajout des images : " .$e->getMessage());
        }
        var_dump($_FILES['image_produit']['tmp_name']);
        //header("Location: ../Vue/client.php");
    } catch (Exception $e){
        die("Erreur lors de l'ajout de l'annonce : " .$e->getMessage());
    }
}
else{
    echo('Erreur dans la publication de votre annonce.');
}
