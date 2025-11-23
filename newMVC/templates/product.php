<?php

// $user = $_SESSION['user'];
// var_dump($annoncement);
?>

<?php
$title = "Page du produit";
$style = "templates/style/style.css";
$script = "templates/JS/favorite.js";

// $isFav = true;
?>

<?php ob_start(); ?>
<style>
    footer {
        position: absolute;
        bottom: 0;
    }
</style>

<header>
    <?php include('preset/header.php'); ?>
</header>

<button data-id-product=<?= $p['id_product'] ?> data-is-fav=<?= $isFav ? 'true' : 'false'?> id="fav" style="background-color: light-grey; width: 150px; font-size: 2em;"><?= $isFav ? "★" : "☆"; ?></button>
<h1><?= $p['title']; ?></h1>
<?php if ($current_price === null) {
    $current_price = $p['start_price'];
}
?>
<p>Prix actuel : <?= htmlspecialchars($current_price) ?> €</p>
<p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
<p><?= $p['description']; ?></p>

<footer>
    <?php include('preset/footer.php'); ?>
</footer>

<!-- Ton script du timer -->
<script src="templates/JS/timer.js"></script>

<script>
    // Initialisation de Swiper
    document.addEventListener('DOMContentLoaded', function () {
        // Lancer tous les timers de la page
        document.querySelectorAll('.timer').forEach(el => {
            const endDate = el.getAttribute('data-end');
            startCountdown(endDate, el); // Fonction importée depuis timer.js
        });
    });
</script>
<?php $content = ob_get_clean() ?>

<?php require('preset/layout.php'); ?>