<?php
require_once('src/lib/database.php');
require_once('src/model/product.php');

$title = "Page d'accueil";
$style = "templates/style/index.css";
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php ob_start(); ?>
<?php include('preset/second-header.php'); ?>

<main>
  <?php
  $pdo = DatabaseConnection::getConnection();
  $productRepository = new ProductRepository($pdo);
  
  // CORRECTION ARCHITECTURALE : 
  // On délègue la responsabilité des performances à la base de données.
  // getActiveFeaturedProducts() doit exécuter une requête JOIN optimisée avec LIMIT 12.
  $products = $productRepository->getActiveFeaturedProducts(12);
  ?>

  <?php if (empty($products)): ?>
    <p>Aucune annonce disponible pour le moment.</p>
  <?php else: ?>
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php foreach ($products as $p): 
            // Sécurisation du calcul de prix côté contrôleur/repository
            $current_price = !empty($p['last_price']) ? $p['last_price'] : $p['start_price'];
            $imgUrl = !empty($p['main_image_url']) ? htmlspecialchars($p['main_image_url']) : 'templates/Images/default.png';
        ?>
            <a href="index.php?action=product&id=<?= urlencode($p['id_product']) ?>" class="swiper-slide slide-link">
              <div class="image-container">
                <img src="<?= $imgUrl ?>" alt="Image annonce">
                <div class="luxury-overlay">
                  <h3><?= htmlspecialchars($p['title']) ?></h3>

                  <div class="info-row">
                    <i class="fa-regular fa-clock icon-gold"></i>
                    <span class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></span>
                  </div>

                  <div class="info-row price-box">
                    <i class="fa-solid fa-money-bill-wave icon-white"></i>
                    <span class="price"><?= htmlspecialchars(number_format((float)$current_price, 0, ',', ' ')) ?> €</span>
                  </div>

                  <div class="bid-button">Enchérir</div>
                </div>
              </div>
            </a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="content">
    <h1>Nos dernières annonces</h1>
    <div class="annonces">
      <?php if (empty($products)): ?>
        <p>Aucune annonce disponible pour le moment.</p>
      <?php else: ?>
        <?php foreach ($products as $p): 
            $imgUrl = !empty($p['main_image_url']) ? htmlspecialchars($p['main_image_url']) : 'templates/Images/default.png';
            $celebrityName = !empty($p['celebrity_name']) ? $p['celebrity_name'] : 'N/A';
        ?>
          <div class="announce-card">
            <div class="card-img-container">
              <img src="<?= $imgUrl ?>" alt="Image annonce">
            </div>

            <div class="card-body">
              <h3><?= htmlspecialchars($p['title']) ?></h3>
              <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>

              <div class="celebrity-row">
                <div class="avatar-wrapper">
                  <img src="templates/Images/compte.png" class="celebrity-img" alt="Celebrity">
                </div>
                <span class="celebrity-name">Célébrité : <?= htmlspecialchars($celebrityName) ?></span>
              </div>

              <div class="action-row">
                <a class="bid-btn" href="index.php?action=product&id=<?= urlencode($p['id_product']) ?>">Enchérir</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="navigation-footer-box" style="text-align: center; margin-top: 30px;">
    <a id="Voir_annonces_btn" class="btn_voir_annonces" href="index.php?action=buy">Voir toutes les annonces</a>
    <p style="margin-top: 40px;">Ne ratez aucune annonce ! <br> Abonnez-vous dès maintenant et gratuitement à notre newsletter !</p>
    <a class="btn_newsletter" href="index.php?action=newsletter">S'abonner</a>
  </div>

  <section class="qui-sommes-nous">
    <h2>Qui sommes-nous ?</h2>
    <div class="cercles-container">
      <div class="cercle cercle-gauche">
        <div class="icon"><img src="templates/Images/france.png" alt="Icon France" class="icon-france"></div>
        <h3>Site d'enchères d'origine française</h3>
        <p>Site hébergé et réalisé par des Français en France. Disponible uniquement en France !</p>
      </div>

      <div class="cercle cercle-centre">
        <div class="icon"><img src="templates/Images/etoile.png" alt="Icon star" class="icon-star"></div>
        <h3>Centré sur les stars d'internet</h3>
        <p>Site d'enchères où seuls les objets de célébrités sont disponibles. Nous proposons également une grande variété de catégories.</p>
      </div>

      <div class="cercle cercle-droite">
        <div class="icon"><img src="templates/Images/etudiant.png" alt="Icon student" class="icon-student"></div>
        <h3>Réalisé par des étudiants</h3>
        <p>Une équipe de développeurs en BUT Informatique composée de Thomas Barthoux Sauze, Kyllian Riviere et de Jimmy Garnier a réalisé ce site !</p>
      </div>
    </div>
  </section>
</main>

<?php include('preset/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="templates/JS/timer.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
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

    document.querySelectorAll('.timer').forEach(el => {
      const endDate = el.getAttribute('data-end');
      if (endDate && typeof startCountdown === 'function') {
        startCountdown(endDate, el);
      }
    });
  });
</script>

<?php $content = ob_get_clean(); ?>
<?php require('preset/layout.php'); ?>