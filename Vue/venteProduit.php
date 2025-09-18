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
    <script src="" defer></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <h1>Mise en enchére de votre produit</h1>

    <form>
        <div class="containeur_top">
            <div class="nom_annonce_vente">
                <h4>Nom de vôtre annonce</h4>
                <input type="text" name="nom_annonce_vente" placeholder="Nom de vôtre annonce">
            </div>

            <div class="img_selector">
                <h4>Ajouter des images</h4>
                <p>Vous avez la possiblité de mettre maximum 4 images</p>

                <div class="img_annonces">
                    <div class="input_selector_image">
                        <input type="file" name="img_select" onchange="affichageImage()">
                    </div>
                    <img src="" id="img_annonce_1">
                    <img src="" id="img_annonce_2">
                    <img src="" id="img_annonce_3">
                    <img src="" id="img_annonce_4">
                </div>


            </div>

            <div class="information_produit">
                <div class="produit_categorie">
                    <h4>Catégorie :</h4>
                    <select name="lst_categorie_vente" id="lst_categorie_vente">
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
                <input type="date" value="date_debut" name="date_debut">
            </div>
            <div class="date_fin">
                <h4>Date de fin :</h4>
                <input type="date" value="date_fin" name="date_fin">
            </div>
        </div>

        <div class="certificat_authenticite_vente">
            <h4>Certificat d'authenticité</h4>
            <input type="file" value="certificat_autenticite" name="certificat_autenticite">
        </div>

        <div class="description_produit_vente">
            <h4>Faite nous une description de votre produit</h4>
            <textarea placeholder="Votre description ici" name="description_produit" id="description_produit"></textarea>
        </div>

        <button type="submit" name="action" value="submit_new_produitenvente">Publier</button>
    </form>
    
    <script src="../JS/vente_produit.js"></script>
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>