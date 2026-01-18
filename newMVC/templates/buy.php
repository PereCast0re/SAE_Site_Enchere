<?php
$title = "Page d'achats";
$style = "templates/style/buy.css";

?>


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


<?php ob_start(); ?>

<?php include('preset/header.php'); ?>
<?php include("src/controllers/update-index.php"); ?>

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
                    <?php if (new DateTime($p['end_date']) > new DateTime()): ?>

                        <?php
                        $priceRow = $productRepository->getLastPrice($p['id_product']);
                        $current_price = null;

                        if (!empty($priceRow) && isset($priceRow['last_price']) && $priceRow['last_price'] !== null) {
                            $current_price = $priceRow['last_price'];
                        } else {
                            $current_price = $p['start_price'];
                        }
                        ?>

                        <a href="index.php?action=product&id=<?= htmlspecialchars($p['id_product']) ?>"
                            class="swiper-slide slide-link">
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
                                        <span class="price"><?= htmlspecialchars($current_price) ?> €</span>
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

    <div class="search_bar">
        <input type="text" id="searchInput" placeholder="Recherchez une annonce, une catégorie, une célébrité..."
            autocomplete="on">
        <button id="searchButton">Rechercher</button>

        <div id="suggestions"></div>
    </div>

    <div class="content">
        <div class="annonces">
            <?php if (empty($products)): ?>
                <p>Aucune annonce disponible pour le moment.</p>
            <?php else: ?>
                <?php
                $count_displayed = 0;
                $max_to_display = 100;
                ?>

                <?php foreach ($products as $p): ?>

                    <?php
                    if ($count_displayed >= $max_to_display) {
                        break;
                    }

                    if (new DateTime($p['end_date']) > new DateTime()):
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
                                    <button class="wishlist-btn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                    <a class="bid-btn" href="index.php?action=product&id=<?= $p['id_product'] ?>">Enchérir</a>
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
</main>

<?php include('preset/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="templates/JS/timer.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.mySwiper', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
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

        document.querySelectorAll('.timer').forEach(el => {
            const endDate = el.getAttribute('data-end');
            startCountdown(endDate, el);
        });
    });
</script>

<script>
    document.getElementById('searchButton').addEventListener('click', async function () {
        const q = document.getElementById('searchInput').value.trim();
        if (q.length < 2) return;

        const response = await fetch("src/controllers/search.php?q=" + encodeURIComponent(q));
        const results = await response.json();

        const container = document.querySelector(".annonces");
        container.innerHTML = "";

        if (results.length === 0) {
            container.innerHTML = "<p>Aucun résultat trouvé.</p>";
        } else {
            results.forEach(p => {
                const card = document.createElement("div");
                card.classList.add("announce-card");

                let imageHtml = '<div style="height:100px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                if (p.image_url) imageHtml = `<img src="${p.image_url}" alt="Image annonce">`;

                card.innerHTML = `
                ${imageHtml}
                <h3>${p.title}</h3>
                <p>Prix : ${p.price ?? '-'} €</p>
                <p class="timer" data-end="${p.end_date}"></p>
                <a class="btn" href="index.php?action=product&id=${p.id}">Voir</a>
            `;
                container.appendChild(card);
            });

            document.querySelectorAll('.timer').forEach(el => {
                startCountdown(el.getAttribute('data-end'), el);
            });
        }

        const box = document.getElementById('suggestions');
        box.style.display = 'none';
        box.innerHTML = '';
    });
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestions');

    searchInput.addEventListener('keyup', async function () {
        const q = this.value.trim();

        if (q.length < 2) {
            suggestionsBox.style.display = 'none';
            return;
        }

        try {
            const response = await fetch("src/model/suggestion.php?q=" + encodeURIComponent(q));
            const results = await response.json();

            suggestionsBox.innerHTML = '';
            suggestionsBox.style.display = 'block';

            if (results.length === 0) {
                suggestionsBox.innerHTML = '<div style="padding:8px;color:#555;">Aucun résultat</div>';
                return;
            }

            results.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('suggestion-item');
                div.style.padding = '8px';
                div.style.cursor = 'pointer';
                div.style.borderBottom = '1px solid #eee';
                div.style.backgroundColor = '#fff';

                let typeText = '';
                if (item.type === 'product') typeText = 'produit';
                else if (item.type === 'category') typeText = 'catégorie';
                else if (item.type === 'celebrity') typeText = 'célébrité';

                div.textContent = `${item.title} dans ${typeText}`;

                div.onclick = () => {
                    if (item.type === 'product') {
                        window.location.href = "index.php?action=product&id=" + item.product_id;
                    } else if (item.type === 'category') {
                        loadCategory(item.category_id);
                        suggestionsBox.style.display = 'none';
                        searchInput.value = item.title;
                    } else if (item.type === 'celebrity') {
                        loadCelebrity(item.celebrity_id);
                        suggestionsBox.style.display = 'none';
                        searchInput.value = item.title;
                    }
                };

                suggestionsBox.appendChild(div);
            });

        } catch (err) {
            console.error(err);
            suggestionsBox.innerHTML = '<div style="padding:8px;color:red;">Erreur lors de la recherche</div>';
        }
    });

    async function loadCategory(categoryId) {
        const response = await fetch(
            "src/controllers/filterByCategory.php?id=" + categoryId
        );
        const products = await response.json();

        const container = document.querySelector('.annonces');
        container.innerHTML = '';

        if (products.length === 0) {
            container.innerHTML = "<p>Aucune annonce.</p>";
            return;
        }

        products.forEach(p => {
            container.innerHTML += renderProductCard(p);
        });

        document.querySelectorAll('.timer').forEach(el => {
            startCountdown(el.getAttribute('data-end'), el);
        });
    }
    async function loadCelebrity(celebrityId) {
        const response = await fetch(
            "src/controllers/filterByCelebrity.php?id=" + celebrityId
        );
        const products = await response.json();

        const container = document.querySelector('.annonces');
        container.innerHTML = '';

        if (products.length === 0) {
            container.innerHTML = "<p>Aucune annonce.</p>";
            return;
        }

        products.forEach(p => {
            container.innerHTML += renderProductCard(p);
        });

        document.querySelectorAll('.timer').forEach(el => {
            startCountdown(el.getAttribute('data-end'), el);
        });
    }

    function renderProductCard(p) {
        console.log('Produit:', p);
        console.log('Images:', p.images);

        let imageHtml = '<div style="height:100px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';

        if (p.images && p.images.length > 0) {
            console.log('URL image:', p.images[0].url_image);
            imageHtml = `<img src="${p.images[0].url_image}" alt="Image annonce">`;
        }

        return `
        <div class="announce-card">
            ${imageHtml}
            <h3>${p.title}</h3>
            <p class="timer" data-end="${p.end_date}"></p>
            <a class="btn" href="index.php?action=product&id=${p.id_product ?? p.id}">Voir</a>
        </div>
    `;
    }

</script>

<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>