<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="Style/Accueil.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <?php include('header.php'); ?>
  </header>

  <main>
    <?php
      include_once('../Modele/pdo.php');
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
                $images = getImage($p['id_product']);
                if (!empty($images)) {
                  echo '<img src="'.htmlspecialchars($images[0]['url_image']).'" alt="Image annonce">';
                } else {
                  echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                }
              ?>
              <h3><?= htmlspecialchars($p['title']) ?></h3>
              <p><?= htmlspecialchars($p['description']) ?></p>
              <?php $current_price = getLastPrice($p['id_product'])['last_price']; 
                if ($current_price === null) {
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
                $images = getImage($p['id_product']);
                if (!empty($images)) {
                  echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                } else {
                  echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                }
              ?>
              <h3><?= htmlspecialchars($p['title']) ?></h3>
              <!-- Timer -->
              <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
              <a class="btn">Voir</a>
            </div>
          <?php endfor; ?>
        <?php endif; ?>    
      </div>

      <a id="Voir_annonces_btn" class="btn">Voir les annonces</a>
      <br><br><br>
      <a id="Connexion_button" class="btn" href="connection.php">Connexion</a><br><br><br>
      <a id="inscription_button" class="btn" href="inscription.php">S'inscrire</a>

      <h1>Nos catégories en vedette</h1>
      <p>------------TEXTE------------</p>
      <a class="btn">S'abonner</a><br><br><br>
    </div>
  </main>

  <footer>
    <?php include('footer.php'); ?>
  </footer>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Ton script du timer -->
  <script src="../JS/timer.js"></script>

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
</body>
</html>
