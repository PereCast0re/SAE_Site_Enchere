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
            <div class="img_selector">

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
                    <input type="checkbox" id="prix_reserve_checkbox">
                    <div id="input_prix_reserve"></div>
                    <script>
                        afficherInputPrixReserve()
                    </script>
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
    </form>
    

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>