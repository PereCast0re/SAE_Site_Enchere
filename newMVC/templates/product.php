<?php

// $user = $_SESSION['user'];
// var_dump($annoncement);
?>

<?php
$title = "Page du produit";
$style = "templates/style/product.css";
$script = "templates/JS/favorite.js";
?>

<?php ob_start(); ?>

<!-- <?php include('preset/header.php'); ?> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="templates/style/stylePopup.css" rel="stylesheet" />

<div id="popup">
</div>

<div id="toastBox"></div>

<script src="https://kit.fontawesome.com/645d3e5fd2.js" crossorigin="anonymous"></script>

<main>
    <h1><?= $p['title']; ?></h1>

    <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>

    <div class="product-price">
        <?php if ($current_price === null) {
            $current_price = $p['start_price'];
        }
        ?>
        <p>Offre actuelle : <br><span style="color: green">
                <?= htmlspecialchars(number_format($current_price, 0, ',', ' ')) ?> €
            </span>
        </p>
    </div>

    <input id="currentPrice" type="hidden" name="currentPrice" value=<?= $current_price ?>>
    <input id="idProduct" type="hidden" name="idProduct" value=<?= $p['id_product'] ?>>

    <button class="btn" id="bid_button" type="button" onclick="ouvrirPopup('BidForm')">Enchérir</button>


    <div style="font-size: 2em" data-is-fav="<?= $isFav ? 'true' : 'false' ?>" id="fav">
        <?= $isFav ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'; ?>
    </div>
    <p><?= $like ?></p>


    

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
</main>

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

<script>
    const toastBox = document.querySelector('#toastBox')

    function showToast(numberValidation, msg) {
        let toast = document.createElement('div');
        toast.classList.add('toast');

        if (numberValidation === 1) {
            toast.classList.add('invalid');
            toast.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> ${msg}`;
        }
        else if (numberValidation > 1) {
            toast.classList.add('error');
            toast.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${msg}`;
        } else {
            toast.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${msg}`;
        }

        toastBox.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 6000);
    }
</script>
<?php $content = ob_get_clean() ?>

<?php require('preset/layout.php'); ?>