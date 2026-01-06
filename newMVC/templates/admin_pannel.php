<?php
$title = "Pannau admin";
$style = "templates/style/Accueil.css";
$script = "";

if (!isset($_SESSION['user'])) {
    header('location: index.php?action=connection');
    exit();
}

require_once('src/model/pdo.php');
$user = $_SESSION['user'];
?>


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

<main>

  <div class="content">
    <h1>Annonce a vérifié</h1>
    <div class="annonces">
      <?php $products = getAllProduct_admin(); if (empty($products)): ?>
        <p>Aucune annonce disponible pour le moment.</p>
      <?php else: ?>
        <?php
        $count_displayed = 0;
        $max_to_display = 9;
        ?>

        <?php foreach ($products as $p): ?>

        <?php
        if ($count_displayed >= $max_to_display) {
            break;
        }
            ?>
            <div class="announce-card">
            <?php
                $images = getImage($p['id_product']);
                if (!empty($images)) {
                    echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                } else {
                    echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                }
            ?>
                <h3><?= htmlspecialchars($p['title']) ?></h3>
                <p class="Categorie">Catégorie : <?php $cate = getCategoryFromAnnoncement($p['id_product']); echo($cate['name']);  ?></p>
                <p class="Celebrite">Celebrite : <?php $cele = getCelebrityFromAnnoncement($p['id_product']); echo($cele['name']); ?></p>

                <button class="btn_valide" onclick="alertConfirmation('Republiez cette annonce ?', 'republish', <?php $p['id_product']; ?>">Valide</button>
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
<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php include('preset/layout.php'); ?>