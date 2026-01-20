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
  $products = $productRepository->getAllProduct();
  ?>

  <?php if (empty($products)): ?>
    <p>Aucune annonce disponible pour le moment.</p>
  <?php else: ?>
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php foreach ($products as $p): ?>
          <?php if (new DateTime($p['end_date']) > new DateTime() && $p['status'] == 1): ?>

            <?php
            $priceRow = $productRepository->getLastPrice($p['id_product']);
            $current_price = null;
            if (!empty($priceRow) && isset($priceRow['last_price']) && $priceRow['last_price'] !== null) {
              $current_price = $priceRow['last_price'];
            } else {
              $current_price = $p['start_price'];
            }
            ?>

            <a href="index.php?action=product&id=<?= htmlspecialchars($p['id_product']) ?>" class="swiper-slide slide-link">
              <div class="image-container">
                <?php
                $images = getImage($p['id_product']);
                if (!empty($images)) {
                  echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                }
                ?>

                <div class="luxury-overlay">
                  <h3><?= htmlspecialchars($p['title']) ?></h3>

                  <div class="info-row">
                    <i class="fa-regular fa-clock icon-gold"></i>
                    <span class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></span>
                  </div>

                  <div class="info-row price-box">
                    <i class="fa-solid fa-money-bill-wave icon-white"></i>
                    <span class="price"><?= htmlspecialchars(number_format($current_price, 0, ',', ' ')) ?> €</span>
                  </div>

                  <div class="bid-button">Enchérir</div>
                </div>
              </div>
            </a>

          <?php endif; ?>
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
        <?php
        $count_displayed = 0;
        $max_to_display = 12;
        ?>

        <?php foreach ($products as $p): ?>

          <?php
          if ($count_displayed >= $max_to_display) {
            break;
          }

          if (new DateTime($p['end_date']) > new DateTime() && $p['status'] == 1):
            ?>
            <div class="announce-card">
              <div class="card-img-container">
                <?php
                $images = getImage($p['id_product']);
                if (!empty($images)) {
                  echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                }
                ?>
              </div>

              <div class="card-body">
                <h3><?= htmlspecialchars($p['title']) ?></h3>
                <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>

                <div class="celebrity-row">
                  <div class="avatar-wrapper">
                    <img src="templates/Images/compte.png" class="celebrity-img" alt="Celebrity">
                  </div>
                  <?php
                  $celebrity = $productRepository->getCelebrityNameByAnnoncement($p['id_product']);
                  if (!empty($celebrity)) {
                    echo '<span class="celebrity-name">Célébrité : ' . htmlspecialchars($celebrity['name']) . '</span>';
                  } else {
                    echo '<span class="celebrity-name">Célébrité : N/A</span>';
                  }
                  ?>
                </div>

                <div class="action-row">
                  <!--<button class="wishlist-btn">
                    <i class="fa-regular fa-heart"></i>
                  </button>-->
                  <a class="bid-btn" href="index.php?action=product&id=<?= $p['id_product'] ?>" style="item-align: center;">Enchérir</a>
                </div>
              </div>
            </div>
            <?php $count_displayed++; ?>
          <?php endif; ?>

        <?php endforeach; ?>

        <?php
        if ($count_displayed === 0):
          ?>
          <p>Aucune annonce active disponible pour le moment.</p>
        <?php endif; ?>

      <?php endif; ?>
    </div>
  </div>

  <a id="Voir_annonces_btn" class="btn_voir_annonces" href="index.php?action=buy">Voir les annonces</a>
  <?php $image = null ?>

  <p>Ne ratez aucune annonce ! <br> Abonnez-vous dès maintenant et gratuitement à nos newletters !</p>
  <a class="btn_newsletter" href="index.php?action=newsletter">S'abonner</a><br><br><br>
  </div>
  <section class="qui-sommes-nous">
    <h2>Qui sommes-nous ?</h2>

    <div class="cercles-container">
      <div class="cercle cercle-gauche">
        <div class="icon"><img src="templates/Images/france.png" alt="Icon France" class="icon-france"></div>
        <h3>Site d'enchère d'origine française</h3>
        <p>Site hébergé et réalisé par des français en France. Disponibles uniquement en France !</p>
      </div>

      <div class="cercle cercle-centre">
        <div class="icon">
          <img src="templates/Images/etoile.png" alt="Icon star" class="icon-star">
        </div>
        <h3>Centré sur les stars d'internet</h3>
        <p>Site d'enchère où seul les objets de célébrités sont disponibles. Nous proposons également une grande variété
          de catégories qui peuvent que vous plaire.</p>
      </div>

      <div class="cercle cercle-droite">
        <div class="icon"><img src="templates/Images/etudiant.png" alt="Icon student" class="icon-student"></div>
        <h3>Réalisé par des étudiants</h3>
        <p>Une équipe de développeurs en BUT informatique composé de Thomas Barthoux Sauze, Kyllian Riviere et de Jimmy
          Garnier ont réalisé ce site d'enchère !</p>
      </div>
    </div>
  </section>
</main>

<?php include('preset/footer.php'); ?>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="templates/JS/timer.js"></script>

<script>
  // Initialisation de Swiper
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
      autoplay: {
        delay: 3000, // 3 secondes
        disableOnInteraction: false, // continue même après interaction
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

    // Lancer tous les timers de la page
    document.querySelectorAll('.timer').forEach(el => {
      const endDate = el.getAttribute('data-end');
      startCountdown(endDate, el); // Fonction importée depuis timer.js
    });
  });
</script>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>