<?php

if (!isset($_SESSION['user'])) {
    header('location: index.php?action=connection');
    exit();
}

$user = $_SESSION['user'];

$title = "Page de vente";
$style = "templates/style/accueil.css";
$optional_style1 = "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css";
?>

<?php ob_start(); ?>
    <?php include('preset/header.php'); ?>

    <h1 class="titleVendre">Mise en enchère de votre produit</h1>
    <form class="form_vente_produit" action="index.php?action=addProduct" method="POST" enctype="multipart/form-data">
        <div class="containeur_top">
            <div class="information_produit">
                <div class="nom_annonce_vente">
                    <h4>Nom de votre annonce</h4>
                    <input type="text" name="nom_annonce_vente" placeholder="Nom de votre annonce" required>
                </div>
                <div class="produit_categorie">
                    <h4>Catégorie :</h4>
                    <input type="text" name="lst_categorie_vente" id="lst_categorie_vente" placeholder="Ecrivez vôtre catégorie" required/>
                    <div id="categorie_results">
                        <!-- Ici affichage d'un select -->
                    </div>
                </div>
                <div class="prix_reserve">
                    <h4>Réserve</h4>
                    <input type="checkbox" id="prix_reserve_checkbox" onclick="afficherInputPrixReserve()">
                    <div id="input_prix_reserve"></div>
                </div>
                <div class="date_debut">
                    <h4>Date de début :</h4>
                    <input type="date" name="date_debut" required>
                </div>
                <div class="date_fin">
                    <h4>Date de fin :</h4>
                    <input type="date" name="date_fin" required>
                </div>
                <div id="celebrite_produit" class="celebrite_produit">
                    <h4>Célébrité :</h4>
                    <input type="text" id="inputcelebrity" placeholder="rechercher votre Célébrite">
                    <div id="celebrity_results">
                        
                    </div>
                </div>
            </div>
            
            <div class="img_selector">
            <h4>Ajouter des images</h4>
            <p>Vous avez la possibilité de mettre maximum 4 images</p>

            <div class="img_annonces">
                <div class="main_image">
                    <div class="input_selector_image">
                        <label class="custom-file-upload" for="img1">Image 1</label>
                        <input type="file" id="img1" name="image_produit[]" class="img_selector_input" accept="image/*">
                        <img id="img_preview_1" class="img_preview" src="" alt="Prévisualisation Image 1">
                    </div>
                </div>
                
                <div class="buttom_image">
                    <div class="input_selector_image">
                        <label class="custom-file-upload" for="img2">Image 2</label>
                        <input type="file" id="img2" name="image_produit[]" class="img_selector_input" accept="image/*">
                        <img id="img_preview_2" class="img_preview" src="" alt="Prévisualisation Image 2">
                    </div>
                    <div class="input_selector_image">
                        <label class="custom-file-upload" for="img3">Image 3</label>
                        <input type="file" id="img3" name="image_produit[]" class="img_selector_input" accept="image/*">
                        <img id="img_preview_3" class="img_preview" src="" alt="Prévisualisation Image 3">
                    </div>
                    <div class="input_selector_image">
                        <label class="custom-file-upload" for="img4">Image 4</label>
                        <input type="file" id="img4" name="image_produit[]" class="img_selector_input" accept="image/*">
                        <img id="img_preview_4" class="img_preview" src="" alt="Prévisualisation Image 4">
                    </div>
                </div>
            </div>
        </div>

        </div>

        <div class="certificat_authenticite_vente">
            <h4>Certificat d'authenticité format PDF</h4>
            <input type="file" name="certificat_autenticite" id="certificat_authenticite" accept="application/pdf,image/*">
            <embed src="" width="800" height="500" type="application/pdf" style="margin-left: 20%; margin-right: 20%; display: none;" id="pdf_preview">
        </div>
        <div class="description_produit_vente">
            <h4>Faites-nous une description de votre produit</h4>
            <textarea placeholder="Votre description ici" name="description_produit" id="description_produit" required></textarea>
        </div>

        <button type="submit" name="action" value="submit_new_produitenvente">Publier</button>
    </form>
    

    <?php include('preset/footer.php'); ?>
    
    <script src="templates/JS/vente_produit.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>