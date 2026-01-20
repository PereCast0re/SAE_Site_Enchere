<?php
$title = "Pannau admin";
$style = "templates/style/Accueil.css";
$script = "";

if (!isset($_SESSION['user'])) {
    header('location: index.php?action=connection');
    exit();
}

require_once('src/model/pdo.php');
require_once('src/model/celebrity.php');
require_once('src/model/product.php');

$pdo = DatabaseConnection::getConnection();
$celebrityRepository = new CelebrityRepository($pdo);
$productRepository = new ProductRepository($pdo);

$user = $_SESSION['user'];
?>

<style>
  /* Fond semi-transparent derrière la pop-up */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5); /* fondu noir */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000; /* devant tout */
}

/* Contenu de la pop-up */
.popup-box {
    background: white;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    text-align: center;
    min-width: 300px;
}

.popup-box button {
    margin: 10px 5px 0 5px;
    padding: 5px 15px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
}

.popup-box button#btnConfirm {
    background-color: #4CAF50;
    color: white;
}

.popup-box button#btnCancel {
    background-color: #f44336;
    color: white;
}

</style>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<?php ob_start(); ?>

<?php include('preset/second-header.php'); ?>

<main>
  <div class="newsletter">
    <div class="btn_frm">
      <button class="btn_frm_newsletter" onclick="newsletter()">Crée une newsletter</button>
      <div id="frm_new_newsletter" class="frm_new_newsletter" style="display: none;">
        <form action="index.php?action=sendNewsletter" method="POST">
          <div class="title_newlsetter">
            <h2>Titre de votre Newsletter</h2>
            <input type="text" name="title_news" placeholder="Vôtre titre ici !" required>
          </div>
          <div class="content_Newsletter">
            <h4>Contenue de la newsletter</h4>
            <input type="textarea" name="content_mail_newsletter" placeholder="Ecrire ici votre newsletter">
          </div>
          <div>
            <button type="submit" name="action" value="submit_new_newsletter" onclick="turnOffNewsletter()">Envoyer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="content">
    <h1>Annonce a vérifié</h1>
    <div class="annonces">
      <?php $products = getAllProduct_admin(); if (empty($products)): ?>
        <p>Aucune annonce disponible pour le moment.</p>
      <?php else: ?>
        <?php
        $count_displayed = 0;
        $max_to_display = 12;
        ?>

        <?php foreach ($products as $p): ?>

        <?php
        if ($count_displayed >= $max_to_display) {
            break;
        }
            ?>
            <div class="announce-card">
            <?php
                $images = getImage(id_product: $p['id_product']);
                if (!empty($images)) {
                    echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                } else {
                    echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                }
            ?>
                <h3><?= htmlspecialchars($p['title']) ?></h3>
                <p class="Categorie">Catégorie : <?php $cate = $productRepository->getCategoryFromAnnoncement($p['id_product']); echo($cate && isset($cate['name']) ? htmlspecialchars($cate['name']) : 'Non spécifiée'); ?></p>
                <p class="Celebrite">Celebrite : <?php $cele = $celebrityRepository->getCelebrityFromAnnoncement($p['id_product']); echo($cele && isset($cele['name']) ? htmlspecialchars($cele['name']) : 'Non spécifiée'); ?></p>

                <button class="btn_valide" onclick="alertConfirmation('Validez cette annonce ?', 'validateAnnoncement', <?php echo $p['id_product']; ?>)">Valide</button>
                <button class="btn_supp" onclick="alertConfirmation('Supprimer cette annonce ?', 'deleteProductAdmin', <?php echo $p['id_product']; ?>)">Supprimer</button>
            </div>
            <?php $count_displayed++; ?>

        <?php endforeach; ?>

        <?php
        if ($count_displayed === 0):
          ?>
          <p>Aucune annonce active disponible pour le moment.</p>
        <?php endif; ?>

      <?php endif; ?>
    </div>
  </div>
</main>
<script src="templates/JS/Annonce_publie_client.js" defer></script>
<script src="templates/JS/Newsletter.js" defer></script>
<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php include('preset/layout.php'); ?>