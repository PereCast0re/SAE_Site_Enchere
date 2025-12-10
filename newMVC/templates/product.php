<?php

// $user = $_SESSION['user'];
// var_dump($annoncement);
?>

<?php
$title = "Page du produit";
$style = "templates/style/Accueil.css";
$script = "templates/JS/favorite.js";
?>

<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    .container {
        height: 100%;
        margin: 50px 150px;
    }

    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #444;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mySwiper {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-wrapper {
        display: flex;
        justify-content: center;
    }

    /* Opacité */
    .mySwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }
</style>

<section>
    <hr>
    <h1><?= $p['title']; ?></h1>
    <hr>
</section>

<section>
    <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
    <div>
        <?php if ($current_price === null) {
            $current_price = $p['start_price'];
        }
        ?>
        <p>Prix actuel : <?= htmlspecialchars($current_price) ?> €</p>
    </div>
</section>

<section>
    <div>
        <form id="bid-form" method="POST">
            <input type="hidden" name="currentPrice" value=<?= $current_price ?>>
            <label id="bid-label" for="montant">Donnez votre montant : </label>
            <br>
            <input name="newPrice" id="montant" type="number" min=<?= $current_price + 1 ?> required>
            <br>
            <button id="bid-button" data-id-product=<?= $p['id_product'] ?> type="submit">Enchérir</button>
        </form>
    </div>
    <div>
        <button data-id-product=<?= $p['id_product'] ?> data-is-fav=<?= $isFav ? 'true' : 'false' ?> id="fav"
            style="background-color: light-grey; width: 150px; font-size: 2em;"><?= $isFav ? "★" : "☆"; ?>
        </button>
    </div>
</section>

<p><?= $images[0]["url_image"] ?></p>
<img src=<?= $images[0]["url_image"] ?>>
<?php var_dump($images); ?>

<?php foreach ($images as $image) { ?>
    <img src=<?= $image["url_image"] ?>>
<?php } ?>

<!-- Swiper -->

<div class="container">
    <div style="--swiper-navigation-color: #FFF; --swiper-pagination-color: #FFF" class="swiper mySwiper2">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
            </div>
            <div class="swiper-slide">
                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <div thumbsSlider="" class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
            </div>
            <div class="swiper-slide">
                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
            </div>
        </div>
    </div>
</div>

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

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>

<!-- <script src="templates/JS/manageImagesProduct.js"></script> -->

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