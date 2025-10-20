<?php
require_once("../Modele/pdo.php");

session_start();

if (!isset($_SESSION['client'])) {
    header('location: connexion.php');
    exit();
}

$client = $_SESSION['client'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente</title>
    <link rel="stylesheet" href="Style/style.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <h1>Mise en enchère de votre produit</h1>

    <form class="form_vente_produit" action="../Controlleur/C_publierAnnonce.php" method="POST" enctype="multipart/form-data">
        <div class="containeur_top">
            <div class="nom_annonce_vente">
                <h4>Nom de votre annonce</h4>
                <input type="text" name="nom_annonce_vente" placeholder="Nom de votre annonce" required>
            </div>

            <div class="img_selector">
                <h4>Ajouter des images</h4>
                <p>Vous avez la possibilité de mettre maximum 4 images</p>

                <div class="img_annonces">
                    <!-- Image 1 -->
                    <div class="input_selector_image">
                        <label>Image 1 :</label>
                        <input type="file" name="image_produit[]" id="1" >
                        <img src="" id="img_annonce_1" style="width: 150px; height: 150px; display: none; margin-top: 10px;">
                    </div>

                    <!-- Image 2 -->
                    <div class="input_selector_image">
                        <label>Image 2 :</label>
                        <input type="file" name="image_produit[]" id="2" >
                        <img src="" id="img_annonce_2" style="width: 150px; height: 150px; display: none; margin-top: 10px;">
                    </div>

                    <!-- Image 3 -->
                    <div class="input_selector_image">
                        <label>Image 3 :</label>
                        <input type="file" name="image_produit[]" id="3" >
                        <img src="" id="img_annonce_3" style="width: 150px; height: 150px; display: block; margin-top: 10px;">
                    </div>

                    <!-- Image 4 -->
                    <div class="input_selector_image">
                        <label>Image 4 :</label>
                        <input type="file" name="image_produit[]" id="4">
                        <img src="" id="img_annonce_4" style="width: 150px; height: 150px; display: none; margin-top: 10px;">
                    </div>
                </div>
            </div>

            <div class="information_produit">
                <div class="produit_categorie">
                    <h4>Catégorie :</h4>
                    <select name="lst_categorie_vente" id="lst_categorie_vente" required>
                        <?php
                            $categorie = getCategorie();
                            foreach($categorie as $cate) {
                                echo('<option>'.$cate['nom'].'</option>');
                            }
                        ?>
                    </select>
                </div>
                <div class="prix_reserve">
                    <h4>Réserve</h4>
                    <input type="checkbox" id="prix_reserve_checkbox" onclick="afficherInputPrixReserve()">
                    <div id="input_prix_reserve"></div>
                </div>
            </div>
            <div class="date_debut">
                <h4>Date de début :</h4>
                <input type="date" name="date_debut" required>
            </div>
            <div class="date_fin">
                <h4>Date de fin :</h4>
                <input type="date" name="date_fin" required>
            </div>
        </div>

        <div class="certificat_authenticite_vente">
            <h4>Certificat d'authenticité</h4>
            <input type="file" name="certificat_autenticite" accept="application/pdf,image/*">
        </div>

        <div class="description_produit_vente">
            <h4>Faites-nous une description de votre produit</h4>
            <textarea placeholder="Votre description ici" name="description_produit" id="description_produit" required></textarea>
        </div>

        <button type="submit" name="action" value="submit_new_produitenvente">Publier</button>
    </form>
    
    <footer>
        <?php include('footer.php'); ?>
    </footer>
    
    <script src="../JS/vente_produit.js"></script>
</body>

</html>