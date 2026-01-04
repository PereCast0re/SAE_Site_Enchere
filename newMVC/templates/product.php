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
<link href="templates/style/stylePopup.css" rel="stylesheet" />

<style>
    :root {
        --linear-blue: linear-gradient(#002366, #0046CC);
        --color-blue: #002366;
        --color-orange: #FFA347;
        --color-gold: #D4AF37;
        --color-background: #F0F0F0;
    }

    /* ====================== */
    /* Swiper */
    /* ====================== */
    .container {
        height: 100%;
        margin: 50px 150px;
        user-select: none;
        text-align: center;
        margin: 50px auto;
    }

    .swiper {
        width: 100%;
        height: 500px;
        border-radius: 10px;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        /* background: #444; */
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        place-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .mySwiper {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-wrapper {
        display: flex;
        justify-content: center;
        place-items: center;
    }

    .mySwiper .swiper-slide {
        width: 300px;
        height: auto;
        opacity: 0.4;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .mySwiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }

    .swiper-button-next,
    .swiper-button-prev {
        background-color: #F0F0F0;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ====================== */
    /* Product */
    /* ====================== */

    .btn {
        display: inline-block;
        background-color: #ffffff;
        color: #002366;
        border: 2px solid #D4AF37;
        text-transform: uppercase;
        font-weight: 500;
        font-size: 18px;
        font-family: 'Cormorant Garamond', serif;
        padding: 5px 30px;
        border-radius: 60px;
        box-shadow: 0px 0px 6px -1px;
        text-decoration: none;
        margin-bottom: 15px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #D4AF37;
    }

    .product-title {
        padding: 20px 0px;
        display: flex;
        color: var(--color-blue);
        align-items: center;
    }

    .product-title hr {
        width: 50%;
    }

    .product-title h1,
    h2 {
        padding: 0px 20px;
    }

    #product-timer-price {
        display: flex;
        justify-content: space-around;
        text-align: center;
    }

    .product-price {
        font-size: 1.5em;
    }

    .timer {
        color: var(--color-gold);
        font-size: 2em;
    }

    #product-bid {
        display: flex;
        justify-content: center;
        text-align: center;
        font-size: 1.2em;
        color: var(--color-blue);
    }

    #product-bid button {
        margin: 10px;
    }

    .fav-btn {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 1.5em;
        background-color: #F0F0F0;
        color: var(--color-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 20px;
    }

    #bid-form input {
        width: 200px;
        height: 30px;
        font-size: 1em;
        border: 1.5px solid var(--color-gold);
        border-radius: 60px;
        text-align: center;
    }

    #product-description {
        margin: 50px;
        padding: 50px;
        background-color: white;
        text-align: center;
        border-radius: 60px;
        box-shadow: 0px 0px 6px -1px;
        color: #002366;
        border: 2px solid #D4AF37;
    }

    #product-description h2 {
        padding-bottom: 20px;
    }

    #product-comment {
        display: flex;
        justify-content: center;
        flex-direction: column;
        text-align: center;
    }

    #comment-form textarea {
        width: 70%;
        height: 100px;
        text-align: center;
        font-size: 1em;
        border: 1.5px solid var(--color-gold);
        border-radius: 60px;
    }
</style>

<section class="product-title">
    <hr>
    <h1><?= $p['title']; ?></h1>
    <hr>
</section>

<section id="product-timer-price">
    <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
    <div class="product-price">
        <?php if ($current_price === null) {
            $current_price = $p['start_price'];
        }
        ?>
        <p>Offre actuelle : <br><span
                style="color: green"><?= htmlspecialchars(number_format($current_price, 0, ',', ' ')) ?> €</span></p>
    </div>
</section>

<div id="myToast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body"> Hello, world! This is a toast message. </div> <button type="button"
            class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>


<div id="popup">
</div>
<button id="bid_button" type="button" data-current-price="<?= $current_price ?>"
    onclick="ouvrirPopup('BidForm')">Enchérir</button>

<section id="product-bid">
    <div>
        <form id="bid-form-product" method="POST">
            <input type="hidden" name="currentPrice" value=<?= $current_price ?>>
            <button class="btn" id="bid-button" data-id-product=<?= $p['id_product'] ?> type="submit">Enchérir</button>
        </form>
    </div>
    <div class="fav-btn">
        <button class="btn fav-btn" data-id-product=<?= $p['id_product'] ?> data-is-fav=<?= $isFav ? 'true' : 'false' ?>
            id="fav" style="background-color: light-grey; width: 150px; font-size: 2em;"><?= $isFav ? "★" : "☆"; ?>
        </button>
        <p><?= $like ?></p>
    </div>
</section>


<!-- Swiper -->
<div class="container">
    <?php if (empty($images)) { ?>
        <p>Aucune image disponible pour cette annonce.</p>
    <?php } else { ?>
        <div style="--swiper-navigation-color: #000000; --swiper-pagination-color: #000000;" class="swiper mySwiper2">
            <div class="swiper-wrapper">
                <?php foreach ($images as $image) { ?>
                    <div class="swiper-slide">
                        <img src=<?= $image["url_image"] ?>>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-wrapper">
                <div class="swiper-button-next"></div>
            </div>
            <div class="swiper-button-wrapper">
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <div thumbsSlider="" class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($images as $image) { ?>
                    <div class="swiper-slide">
                        <img src=<?= $image["url_image"] ?>>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<section id="product-description">
    <h2>Description</h2>
    <p><?= htmlspecialchars(strip_tags($p['description'])) ?></p>
</section>

<section class="product-title">
    <hr>
    <h2>Commentaires</h2>
    <hr>
</section>

<section id="product-comment">
    <?php foreach ($comments as $comment) { ?>
        <h3><a
                href="index.php?action=user&id=<?= $comment['id_user'] ?>"><?= htmlspecialchars(strip_tags($comment['full_name'])) ?></a><?= " " . $comment["comment_date"] ?>
        </h3>
        <p><?= htmlspecialchars(strip_tags($comment['comment'])) ?></p>
    <?php } ?>
    <form id="comment-form" method="POST" action="index.php?action=addComment">
        <input type="hidden" name="id" value=<?= $p['id_product'] ?>>
        <br>
        <textarea id="comment-comment" name="comment" placeholder="Laissez un commentaire ici !" type="text"
            required></textarea>
        <br>
        <button class="btn" type="submit">Publier</button>
    </form>
</section>

<!-- <section>
    <form method="POST" action="index.php?action=deleteProduct">
        <input type="hidden" name="id" value=<?= $p['id_product'] ?>>
        <button type="submit">Supprimer</button>
    </form>
</section> -->

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

<script src="templates/JS/OuverturePopUp.js"></script>

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