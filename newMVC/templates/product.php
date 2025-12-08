<?php

// $user = $_SESSION['user'];
// var_dump($annoncement);
?>

<?php
$title = "Page du produit";
$style = "templates/style/style.css";
$script = "templates/JS/favorite.js";

// $isFav = true;
$linkImage3 = "./Annonce/eee/eee_1.jpg";
$linkImage2 = "./Annonce/eee/eee_0.jpg";
$linkImage1 = "./Annonce/test/test_1.jpg";
$linkImage0 = "./Annonce/test/test_0.jpg";
?>

<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

<button data-id-product=<?= $p['id_product'] ?> data-is-fav=<?= $isFav ? 'true' : 'false' ?> id="fav"
    style="background-color: light-grey; width: 150px; font-size: 2em;"><?= $isFav ? "★" : "☆"; ?></button>
<h1><?= $p['title']; ?></h1>
<?php if ($current_price === null) {
    $current_price = $p['start_price'];
}
?>
<p>Prix actuel : <?= htmlspecialchars($current_price) ?> €</p>
<form id="bid-form" method="POST">
    <input type="hidden" name="currentPrice" value=<?= $current_price ?>>
    <label id="bid-label" for="montant">Donnez votre montant : </label>
    <input name="newPrice" id="montant" type="number" min=<?= $current_price + 1 ?> required>
    <button id="bid-button" data-id-product=<?= $p['id_product'] ?> type="submit">Enchérir</button>
</form>

<section>

    <!-- <img id="imgProduct1" data-link-image1=<?= $linkImage1 ?> src=<?= $linkImage1 ?>>
<img id="imgProduct0" data-link-image0=<?= $linkImage0 ?> src=<?= $linkImage0 ?>>
<br>
<button id="changeImage" >Changer l'image</button> -->

    <img id="mainImg" src=<?= $linkImage3 ?>>
    <img class="imgProduct" src=<?= $linkImage2 ?>>
    <img class="imgProduct" src=<?= $linkImage1 ?>>
    <img class="imgProduct" src=<?= $linkImage0 ?>>

</section>

<p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
<p><?= $p['description']; ?></p>
<h1>Commentaires</h1>
<?php foreach ($comments as $comment) { ?>
    <h2><a
            href="index.php?action=user&id=<?= $comment['id_user'] ?>"><?= $comment['full_name'] ?></a><?= " " . $comment["comment_date"] ?>
    </h2>
    <p><?= $comment['comment'] ?></p>
<?php } ?>
<form method="POST" action="index.php?action=addComment">
    <input type="hidden" name="id" value=<?= $p['id_product'] ?>>
    <label for="comment-comment">Commentaire</label>
    <br>
    <textarea id="comment-comment" name="comment" type="text" required></textarea>
    <br>
    <button type="submit">Publier</button>
</form>

<?php include('preset/footer.php'); ?>

<script src="templates/JS/manageImagesProduct.js"></script>

<script src="templates/JS/bid.js"></script>

<script src="templates/JS/timer.js"></script>

<script>
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