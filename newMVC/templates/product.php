<?php

// $user = $_SESSION['user'];
// var_dump($annoncement);
?>

<?php
$title = "Page du produit";
$style = "templates/Style/product.css";
$script = "templates/JS/favorite.js";
?>

<?php ob_start(); ?>

<?php include('preset/second-header.php'); ?>

<input id="currentPrice" type="hidden" name="currentPrice" value=<?= $current_price ?>>
<input id="idProduct" type="hidden" name="idProduct" value=<?= $p['id_product'] ?>>
<input id="userID" type="hidden" name="userID" value=<?= $p['userID'] ?>>
<input id="userID" type="hidden" name="userID" value=<?= isset($_SESSION['user']["id_user"]) ? $_SESSION['user']["id_user"] : "" ?>>

<div id="popup">
</div>

<div id="toastBox"></div>

<main>

    <section id="product-section">
        <div class="myDiv1">
            <section id="fav-section">
                <div id="fav-container">
                    <h2 data-is-fav="<?= $isFav ? 'true' : 'false' ?>" id="fav">
                        <?= $isFav ? '<i class="fa-solid fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>'; ?>
                    </h2>
                    <h2>
                        <?= $like ?>
                    </h2>
                </div>
            </section>

            <div id="swiper-container">
                <?php if (empty($images)) { ?>
                    <p>Aucune image disponible pour cette annonce.</p>
                <?php } else if (count($images) < 2) { ?>
                        <img class="uniqueImage" src=<?= $images[0]["url_image"] ?> alt=<?= $images[0]["alt"] ?>>
                <?php } else { ?>
                        <div thumbsSlider="" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                            <?php foreach ($images as $image) { ?>
                                    <div class="swiper-slide">
                                        <img src=<?= $image["url_image"] ?>>
                                    </div>
                            <?php } ?>
                            </div>
                        </div>
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                            <div class="swiper-wrapper">
                            <?php foreach ($images as $image) { ?>
                                    <div class="swiper-slide">
                                        <img src=<?= $image["url_image"] ?>>
                                    </div>
                            <?php } ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                <?php } ?>
            </div>
            <section id="product-description">
                <h2 class="title-section">Description</h2>
                <p>
                    <?= htmlspecialchars(strip_tags($p['description'])) ?>
                </p>
            </section>
        </div>


        <div class="myDiv2">
            <div class="timer-container">
                <h2 class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></h2>
            </div>
            <div class="myBox1">
                <h1>
                    <?= $p['title']; ?>
                </h1>
                <p>Catégorie</p>
                <ul>
                    <li><?= $category["name"] ?></li>
                    <li><i class="fa-solid fa-location-dot"></i> <?= $p["userCity"] ?></li>
                </ul>
                <p>Celebrité</p>
                <div class="celebrity-section">
                    <?php if (!empty($p["celebrityUrl"])) { ?>
                        <div>
                            <img src=<?= $p["celebrityUrl"] ?> alt=<?= $p["celebrityUrl"] ?>>
                        </div>
                    <?php } else { ?>
                        <i class="fa-solid fa-star"></i>
                    <?php } ?>
                    <h3><?= $p["celebrityName"] ?></h3>
                </div>
                <p>Vendu par</p>
                <div class="celebrity-section">
                    <a href="index.php?action=user&id=<?= $p['userID'] ?>">
                        <i class="fa-solid fa-user"></i>
                        <h3>
                            <?= $p["fullname"] ?>
                        </h3>
                    </a>
                </div>
            </div>
            <div class="price-container">
                <h1>
                    <?= htmlspecialchars(number_format($current_price, 0, ',', ' ')) ?> €
                </h1>
                <div>
                    <?php if ($reservePrice === 0) { ?>
                        <p>Aucun prix de réserve</p>
                    <?php } else if ($reservePrice < $current_price) { ?>
                            <p>Prix de réserve atteint</p>
                    <?php } else { ?>
                            <p>Prix de réserve non atteint</p>
                    <?php } ?>
                </div>
            </div>
            <div class="myBox2">
                <div class="price-ex-section">
                    <?php foreach ($price_ex as $price) { ?>
                        <button id="bid-ex-btn" data-price="<?= $price ?>" data-id="<?= $id_product ?>"
                            data-current="<?= $current_price ?>" onclick="ouvrirPopup('BidValidation', this)">
                            <?= htmlspecialchars(number_format($price, 0, ',', ' ')) ?>
                        </button>
                    <?php } ?>
                </div>
                <button class="btn" id="bid_button" type="button" onclick="ouvrirPopup('BidForm')">Enchérir</button>
            </div>
            <?php if (!empty($certificate)) { ?>
                <div class="certificate-section">
                    <h3>Certificat d'authencité</h3>
                    <a class="btn" href="<?= $certificate[0]['url_image'] ?>" target="_blank">
                        Ouvrir
                    </a>
                </div>
            <?php } ?>

        </div>
    </section>

    <section id="comment-section">
        <div>
            <h2 class="title-section">Commentaires (<span id="comments-counter">0</span>)</h2>
            <section id="product-comment">
                <ul id="comments" class=""></ul>

                <form id="comment-form" method="POST" action="index.php?action=addComment">
                    <input type="hidden" name="id" value=<?= $p['id_product'] ?>>
                    <br>
                    <textarea id="comment-comment" name="comment" placeholder="Laissez un commentaire ici !" type="text"
                        required></textarea>
                    <br>
                    <button class="btn" type="submit">Publier</button>
                </form>
            </section>

            <template id="comment-template">
                <div class="comment-container">
                    <h3 class="comment-author-name">NOM</h3>
                    <p class="comment-content">CONTENU</p>
                </div>
            </template>
        </div>
    </section>

</main>

<?php include('preset/footer.php'); ?>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    const swiperSlides = document.querySelectorAll('.mySwiper .swiper-slide');
    const slideCount = swiperSlides.length;

    const slidesToShow = Math.min(slideCount, 4);

    var swiper = new Swiper(".mySwiper", {
        direction: 'vertical',
        spaceBetween: 0,
        slidesPerView: slidesToShow,
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

    document.querySelectorAll('.mySwiper .swiper-slide').forEach((slide, index) => {
        slide.addEventListener('mouseenter', () => {
            swiper2.slideTo(index);
        });
    });
</script>

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

<!-- Script pour les toast -->
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
        }, 5000);
    }
</script>

<script src="https://kit.fontawesome.com/645d3e5fd2.js" crossorigin="anonymous"></script>

<script src="templates/JS/comment.js"></script>

<?php $content = ob_get_clean() ?>

<?php require('preset/layout.php'); ?>