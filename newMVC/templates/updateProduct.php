<?php

if (!isset($_SESSION['user'])) {
    header('location: index.php?action=connection');
    exit();
}

$user = $_SESSION['user'];
$infoProduct = $_SESSION['updateProduct'];

$title = "Page de vente";
$style = "templates/Style/SellProduct.css";
$optional_style1 = "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css";
?>

<?php ob_start(); ?>
<?php include('preset/header.php'); ?>

    <h1 class="titleVendre">Modification de votre produit</h1>
    <form class="form_vente_produit" action="index.php?action=finalUpdateProduct" method="POST" enctype="multipart/form-data">
        <div class="containeur_top">
            <div class="information_produit">
                <div class="nom_annonce_vente">
                    <h4>Nom de votre annonce</h4>
                    <input type="text" name="nom_annonce_vente" placeholder="Nom de votre annonce" value="<?php echo($infoProduct['product'][0]['title']); ?>" required>
                </div>
                <div class="produit_categorie">
                    <h4>Catégorie :</h4>
                    <input type="text" name="lst_categorie_vente" id="lst_categorie_vente" placeholder="Ecrivez vôtre catégorie" value="<?php echo($infoProduct['categorie']['name']); ?>" required/>
                    <div id="categorie_results">
                        <!-- Ici affichage d'un select -->
                    </div>
                </div>
                <div class="prix_reserve">
                    <h4>Réserve</h4>
                    <input type="checkbox" id="prix_reserve_checkbox" onclick="afficherInputPrixReserve()" value="<?php echo($infoProduct['product'][0]['reserve_price']); ?>" <?php if(!is_null($infoProduct['product'][0]['reserve_price'])) { echo 'checked'; } ?>>
                    <div id="input_prix_reserve"></div>
                </div>
                <div class="date_debut">
                    <h4>Date de début :</h4>
                    <input type="date" name="date_debut" value="<?php echo(date('Y-m-d', strtotime($infoProduct['product'][0]['start_date']))); ?>" required>
                </div>
                <div class="date_fin">
                    <h4>Date de fin :</h4>
                    <input type="date" name="date_fin" value="<?php echo(date('Y-m-d', strtotime($infoProduct['product'][0]['end_date']))); ?>" required>
                </div>
                <div id="celebrite_produit" class="celebrite_produit">
                    <h4>Célébrité :</h4>
                    <input type="text" name="inputcelebrity" id="inputcelebrity" placeholder="rechercher votre Célébrite" value="<?php echo($infoProduct['celebrity']['name']); ?>">
                    <div id="celebrity_results">
                        
                    </div>
                </div>
            </div>
        <div class="img_selector">
            <h4>Vos photos</h4>
            <p>Vous avez la possibilité de mettre maximum 4 images et d'une taille maximal de 10 Megas</p>

            <div class="img_annonces">
                <div class="main_image">
                    <div class="input_selector_image">
                        <?php if (!empty($infoProduct['file'][0]['path_image'])): ?>
                            <img id="img_preview_1" class="img_preview" src="<?php echo $infoProduct['file'][0]['path_image']; ?>" style="display: block;" alt="Prévisualisation Image 1">
                        <?php else: ?>
                            <img id="img_preview_1" class="img_preview" src="" style="display: none;" alt="Prévisualisation Image 1">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="buttom_image">
                    <div class="input_selector_image">
                        <?php if (!empty($infoProduct['file'][1]['path_image'])): ?>
                            <img id="img_preview_2" class="img_preview" src="<?php echo $infoProduct['file'][1]['path_image']; ?>" style="display: block;" alt="Prévisualisation Image 2">
                        <?php else: ?>
                            <img id="img_preview_2" class="img_preview" src="" style="display: none;" alt="Prévisualisation Image 2">
                        <?php endif; ?>
                    </div>

                    <div class="input_selector_image">
                        <?php if (!empty($infoProduct['file'][2]['path_image'])): ?>
                        <?php else: ?>
                            <img id="img_preview_3" class="img_preview" src="" style="display: none;" alt="Prévisualisation Image 3">
                        <?php endif; ?>
                    </div>

                    <div class="input_selector_image">
                        <?php if (!empty($infoProduct['file'][3]['path_image'])): ?>
                            <img id="img_preview_4" class="img_preview" src="<?php echo $infoProduct['file'][3]['path_image']; ?>" style="display: block;" alt="Prévisualisation Image 4">
                        <?php else: ?>
                            <img id="img_preview_4" class="img_preview" src="" style="display: none;" alt="Prévisualisation Image 4">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

        <div class="certificat_authenticite_vente">
            <?php if (!empty($infoProduct['certificat'][0]['path_image'])): ?>
                <h4>Certificat d'authenticité format PDF</h4>
                <embed src="<?php echo($infoProduct['certificat'][0]['path_image']); ?>" width="800" height="500" type="application/pdf" style="margin-left: 20%; margin-right: 20%; display: block;" id="pdf_preview">
            <?php endif; ?>
        </div>
        <div class="description_produit_vente">
            <h4>Faites-nous une description de votre produit</h4>
            <textarea placeholder="Votre description ici" name="description_produit" id="description_produit" required><?php echo($infoProduct['product'][0]['description']); ?></textarea>
        </div>

        <input type="hidden" name="id_product" value="<?php echo($infoProduct['product'][0]['id_product']); ?>">
    <button type="submit" class="submit_new_produitenvente" name="action" value="submit_new_produitenvente">Modifier</button>
</form>


<?php include('preset/footer.php'); ?>

<script src="templates/JS/vente_produit.js" defer></script>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>