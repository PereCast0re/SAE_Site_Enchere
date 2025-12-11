<?php
$title = "Page d'accueil";
$style = "templates/style/Accueil.css";

?>


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

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
          <?php if (new DateTime($p['end_date']) > new DateTime()): ?>
            <div class="swiper-slide">

              <div class="image-container">
                <?php
                $images = getImage($p['id_product']);
                if (!empty($images)) {
                  echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                } else {
                  // Le placeholder reste le contenu principal
                  echo '<div class="no-image-placeholder">Aucune image disponible</div>';
                }
                ?>

                <div class="text-content-overlay">
                  <h3><?= htmlspecialchars($p['title']) ?></h3>
                  <?php
                  $priceRow = getLastPrice($p['id_product']);
                  $current_price = null;
                  if (!empty($priceRow) && isset($priceRow[0]['MAX(new_price)']) && $priceRow[0]['MAX(new_price)'] !== null) {
                    $current_price = $priceRow[0]['MAX(new_price)'];
                  } else {
                    $current_price = $p['start_price'];
                  }
                  ?>
                  <p>Prix actuel : <?= htmlspecialchars($current_price) ?> €</p>
                  <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
                </div>
              </div>

            </div>
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
            $max_to_display = 9;  
            ?>
            
            <?php foreach ($products as $p): ?>
                
                <?php
                if ($count_displayed >= $max_to_display) {
                    break; 
                }
                
                if (new DateTime($p['end_date']) > new DateTime()): 
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
                        <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
                        <a class="btn" href="index.php?action=product&id=<?= $p['id_product'] ?>">Voir</a>
                    </div>
                    <?php $count_displayed++; ?>
                <?php endif; ?>

            <?php endforeach; ?>

            <?php 
            if ($count_displayed === 0) :
            ?>
                <p>Aucune annonce active disponible pour le moment.</p>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>

    <a id="Voir_annonces_btn" class="btns" href="index.php?action=buy">Voir les annonces</a>
    <br><br><br>
    <a id="Connexion_button" class="btns" href="index.php?action=connection">Connexion</a><br><br><br>
    <a id="inscription_button" class="btns" href="index.php?action=inscription">S'inscrire</a>

    <h1>Nos catégories en vedette</h1>
    <div class="category">
      <?php for ($i = 0; $i < min(3, count(getCategory())); $i++): ?>
        <?php $cat = getCategory()[$i]; ?>
        <div class="category-card">
          <?php //$images = getImageCategory($cat['id_category']);
            if (!empty($images)) {
              echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
            } else {
              echo '<div style="height:100px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
            }
            ?>
          <h3><?= htmlspecialchars($cat['name']) ?></h3>
          <a class="btn">Voir</a>
        </div>
      <?php endfor; ?>
    </div>
    <p>------------TEXTE------------</p>
    <a class="btns" href="https://www.youtube.com/watch?v=xvFZjo5PgG0">S'abonner</a><br><br><br>
  </div>
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