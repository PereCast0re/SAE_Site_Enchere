<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="Style/Accueil.css">

</head>

<body>
  <header>
    <?php include('header.php'); ?>
  </header>

  <main>
    <?php
      include_once('../Modele/pdo.php');
      $annonces = get_annonces_with_images();
    ?>

    <?php if (empty($annonces)): ?>
      <p>Aucune annonce disponible pour le moment.</p>
    <?php else: ?>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php foreach ($annonces as $a): ?>
            <div class="swiper-slide">
              <?php
                $images = get_images_for_annonce($a['id_annonce']);
                if (!empty($images)) {
                  echo '<img src="'.htmlspecialchars($images[0]['url_image']).'" alt="Image annonce">';
                } else {
                  echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                }
              ?>
              <h3><?= htmlspecialchars($a['titre']) ?></h3>
              <p><?= htmlspecialchars($a['description']) ?></p>
              <p>Prix de départ : <?= htmlspecialchars($a['prix_en_cours']) ?> €</p>
              <p>Date de fin : <?= htmlspecialchars($a['date_de_fin']) ?></p>
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
        <a id="Voir_annonces_btn" class="btn">Voir les annonces</a>
        <br><br><br>

        <a id="Connexion_button" class="btn" href="connexion.php">Connexion</a><br><br><br>
        <a id="inscription_button" class="btn" href="inscription.php">S'inscrire</a>

        <h1>Nos catégories en vedette</h1>
        <p>------------TEXTE------------</p>
        <a class="btn">BTN</a><br><br><br>
    </div>
  </main>

  <footer>
    <?php include('footer.php'); ?>
  </footer>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
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
    });
  </script>
</body>
</html>
