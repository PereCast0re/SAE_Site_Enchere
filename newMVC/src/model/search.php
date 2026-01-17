<?php
$title = "Page d'achats";
$style = "templates/style/Accueil.css";
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<?php ob_start(); ?>

<?php include('preset/header.php'); ?>
<?php include("src/controllers/update-index.php"); ?>

<main>
    <div class="search_bar">
        <input type="text" id="searchInput" placeholder="Rechercher une annonce..." autocomplete="off">
        <button id="searchButton">Rechercher</button>
        <div id="suggestions" style="position:absolute; background:white; border:1px solid #ccc; width:300px; display:none;"></div>
    </div>

    <div class="content">
        <h1>Nos annonces</h1>
        <div class="annonces">
            <?php
            $pdo = DatabaseConnection::getConnection();
            $productRepository = new ProductRepository($pdo);
            $products = $productRepository->getAllProduct();

            if (empty($products)):
                echo "<p>Aucune annonce disponible pour le moment.</p>";
            else:
                foreach ($products as $p):
                    if (new DateTime($p['end_date']) > new DateTime()):
                        $images = getImage($p['id_product']);
                        $current_price = $productRepository->getLastPrice($p['id_product'])[0]['MAX(new_price)'] ?? $p['start_price'];
                        ?>
                        <div class="announce-card">
                            <?php
                            if (!empty($images)) {
                                echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                            } else {
                                echo '<div style="height:100px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                            }
                            ?>
                            <h3><?= htmlspecialchars($p['title']) ?></h3>
                            <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
                            <p>Prix actuel : <?= htmlspecialchars($current_price) ?> €</p>
                            <a class="btn" href="index.php?action=product&id=<?= $p['id_product'] ?>">Voir</a>
                        </div>
                    <?php
                    endif;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</main>

<?php include('preset/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="templates/JS/timer.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Lancer les timers pour les annonces initiales
    document.querySelectorAll('.timer').forEach(el => {
        const endDate = el.getAttribute('data-end');
        startCountdown(endDate, el);
    });

    // Rechercher avec le bouton
    document.getElementById('searchButton').addEventListener('click', async function () {
        const q = document.getElementById('searchInput').value.trim();
        if (q.length < 2) return alert("Tapez au moins 2 lettres");

        const response = await fetch("src/controllers/search.php?q=" + encodeURIComponent(q));
        const results = await response.json();

        const container = document.querySelector(".annonces");
        container.innerHTML = "";

        if (results.length === 0) {
            container.innerHTML = "<p>Aucun résultat trouvé.</p>";
            return;
        }

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

        // Re-lancer les timers pour les nouveaux résultats
        document.querySelectorAll('.timer').forEach(el => {
            startCountdown(el.getAttribute('data-end'), el);
        });
    });

    // Suggestions en live
    document.getElementById('searchInput').addEventListener('keyup', async function () {
        const q = this.value;
        if (q.length < 2) {
            document.getElementById('suggestions').style.display = 'none';
            return;
        }

        const response = await fetch("src/controllers/suggestion.php?q=" + encodeURIComponent(q));
        const results = await response.json();

        const box = document.getElementById('suggestions');
        box.innerHTML = "";
        box.style.display = "block";

        results.forEach(item => {
            const div = document.createElement("div");
            div.style.padding = "8px";
            div.style.cursor = "pointer";
            div.innerHTML = item.titre;

            div.onclick = () => {
                window.location.href = "index.php?action=product&id=" + item.id;
            };

            box.appendChild(div);
        });
    });
});
</script>

<?php $content = ob_get_clean(); ?>
<?php require('preset/layout.php'); ?>
