<?php
$title = "Page de connexion";
$style = "templates/style/Accueil.css";

?>


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


<?php ob_start(); ?>
<header>
  <?php include('preset/header.php'); ?>
</header>

<main>
  <?php
  require_once('src/model/pdo.php');
  $products = getAllProduct();
  ?>

  <?php if (empty($products)): ?>
    <p>Aucune annonce disponible pour le moment.</p>
  <?php else: ?>
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php foreach ($products as $p): ?>
          <div class="swiper-slide">
            <?php
            //$images = getImage($p['id_product']);
            if (!empty($images)) {
              echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
            } else {
              echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
            }
            ?>
            <h3><?= htmlspecialchars($p['title']) ?></h3>
            <p><?= htmlspecialchars($p['description']) ?></p>
            <?php
            $priceRow = getLastPrice($p['id_product']);
            // $priceRow est un tableau de lignes; la valeur est dans $priceRow[0]['MAX(new_price)']
            $current_price = null;
            if (!empty($priceRow) && isset($priceRow[0]['MAX(new_price)']) && $priceRow[0]['MAX(new_price)'] !== null) {
                $current_price = $priceRow[0]['MAX(new_price)'];
            } else {
                $current_price = $p['start_price'];
            }
            ?>
            <p>Prix actuel : <?= htmlspecialchars($current_price) ?> €</p>
            <!-- Timer -->
            <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Navigation & pagination -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-pagination"></div>
    </div>
  <?php endif; ?>

  <div class="content">
    <h1>Nos dernières annonces</h1>
    <div class="annonces">
      <?php if (empty($products)): ?>
        <p>Aucune annonce disponible pour le moment.</p>
      <?php else: ?>
        <?php for ($i = 0; $i < min(7, count($products)); $i++): ?>
          <?php $p = $products[$i]; ?>
          <div class="announce-card">
            <?php
            //$images = getImage($p['id_product']);
            if (!empty($images)) {
              echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
            } else {
              echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
            }
            ?>
            <h3><?= htmlspecialchars($p['title']) ?></h3>
            <!-- Timer -->
            <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
            <a class="btn" href="index.php?action=product&id=<?= $p['id_product'] ?>">Voir</a>
          </div>
        <?php endfor; ?>
      <?php endif; ?>
    </div>

    <a id="Voir_annonces_btn" class="btn">Voir les annonces</a>
    <br><br><br>
    <a id="Connexion_button" class="btn" href="index.php?action=connection">Connexion</a><br><br><br>
    <a id="inscription_button" class="btn" href="index.php?action=inscription">S'inscrire</a>

    <h1>Nos catégories en vedette</h1>
    <div class="category">
      <?php for ($i = 0; $i < min(3, count(getCategory())); $i++): ?>
        <?php $cat = getCategory()[$i]; ?>
        <div class="category-card">
          <?php //$images = getImage($p['id_product']);
          if (!empty($images)) {
            echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
          } else {
            echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
          }
          ?>
          <h3><?= htmlspecialchars($cat['name']) ?></h3>
          <a class="btn">Voir</a>
        </div>
      <?php endfor; ?>
    </div>
    <p>------------TEXTE------------</p>
    <a class="btn">S'abonner</a><br><br><br>
  </div>
</main>

<footer>
  <?php include('preset/footer.php'); ?>
</footer>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="templates/JS/timer.js"></script>

<script>
  // Initialisation de Swiper
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
      loop: true,
      slidesPerView: 1,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });

    // Lancer tous les timers de la page
    document.querySelectorAll('.timer').forEach(el => {
      const endDate = el.getAttribute('data-end');
      startCountdown(endDate, el); // Fonction importée depuis timer.js
    });
  });
</script>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>