<?php
/**
 * Vue : Page d'achats / Catalogue des annonces
 * * Reçoit une variable $products préparée par le contrôleur.
 */
$title = "Page d'achats";
$style = "templates/style/Accueil.css";
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

<main>
    <div class="search_bar" style="position: relative;">
        <input type="text" id="searchInput" placeholder="Rechercher une annonce..." autocomplete="off">
        <button id="searchButton">Rechercher</button>
        <div id="suggestions" style="position: absolute; top: 100%; left: 0; background: white; border: 1px solid #ccc; width: 300px; display: none; z-index: 1000;"></div>
    </div>

    <div class="content">
        <h1>Nos annonces</h1>
        <div class="annonces">
            <?php if (empty($products)): ?>
                <p>Aucune annonce disponible pour le moment.</p>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <div class="announce-card">
                        <?php if (!empty($p['images']) && isset($p['images'][0]['url_image'])): ?>
                            <img src="<?= htmlspecialchars($p['images'][0]['url_image']) ?>" alt="Image annonce">
                        <?php else: ?>
                            <div class="no-image" style="height:100px; display:flex; align-items:center; justify-content:center; background:#f0f0f0;">
                                Aucune image disponible
                            </div>
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
                        <p>Prix actuel : <?= htmlspecialchars($p['current_price']) ?> €</p>
                        <a class="btn" href="index.php?action=product&id=<?= urlencode($p['id_product']) ?>">Voir</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include('preset/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="templates/JS/timer.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    /**
     * Initialise le compte à rebours sur un élément donné
     */
    function initTimer(element) {
        const endDate = element.getAttribute('data-end');
        if (typeof startCountdown === 'function') {
            startCountdown(endDate, element);
        }
    }

    // Lancement des timers initiaux
    document.querySelectorAll('.timer').forEach(initTimer);

    // 1. Gestion de la recherche par bouton
    document.getElementById('searchButton').addEventListener('click', async function () {
        const q = document.getElementById('searchInput').value.trim();
        if (q.length < 2) return alert("Tapez au moins 2 lettres");

        try {
            const response = await fetch("src/controllers/search.php?q=" + encodeURIComponent(q));
            if (!response.ok) throw new Error("Erreur serveur lors de la recherche");
            
            const results = await response.json();
            const container = document.querySelector(".annonces");
            container.innerHTML = "";

            if (results.length === 0) {
                container.innerHTML = "<p>Aucun résultat trouvé.</p>";
                return;
            }

            // Reconstruction sécurisée du DOM pour éviter les failles XSS
            results.forEach(p => {
                // Correspondance exacte avec les clés retournées par ton API search.php
                if (p.type === 'product') {
                    const card = document.createElement("div");
                    card.classList.add("announce-card");

                    const mainImage = (p.images && p.images.length > 0) ? p.images[0].url_image : null;
                    
                    // Sécurisation textuelle
                    const secureTitle = document.createTextNode(p.title).textContent;
                    const securePrice = p.current_price ?? '-';

                    let imageHtml = `<div style="height:100px;display:flex;align-items:center;justify-content:center;background:#f0f0f0;">Aucune image</div>`;
                    if (mainImage) {
                        imageHtml = `<img src="${encodeURI(mainImage)}" alt="Image annonce">`;
                    }

                    card.innerHTML = `
                        ${imageHtml}
                        <h3>${secureTitle}</h3>
                        <p class="timer" data-end="${htmlspecialchars_js(p.end_date)}"></p>
                        <a class="btn" href="index.php?action=product&id=${parseInt(p.id_product)}">Voir</a>
                    `;
                    container.appendChild(card);
                }
            });

            // Relancer les compteurs sur le nouveau DOM injecté
            container.querySelectorAll('.timer').forEach(initTimer);

        } catch (error) {
            console.error(error);
        }
    });

    // 2. Suggestions en direct (Autocomplete)
    document.getElementById('searchInput').addEventListener('input', async function () {
        const q = this.value.trim();
        const box = document.getElementById('suggestions');
        
        if (q.length < 2) {
            box.style.display = 'none';
            return;
        }

        try {
            const response = await fetch("src/controllers/suggestion.php?q=" + encodeURIComponent(q));
            if (!response.ok) return;
            
            const results = await response.json();
            box.innerHTML = "";

            if (results.length === 0) {
                box.style.display = 'none';
                return;
            }

            box.style.display = "block";
            results.forEach(item => {
                const div = document.createElement("div");
                div.style.padding = "8px";
                div.style.cursor = "pointer";
                // item.titre correspond au format JSON de ton suggestion.php
                div.textContent = item.titre; 

                div.onclick = () => {
                    // item.id correspond à l'index Meilisearch ('category_X' ou 'product_X')
                    // Extraction de l'ID numérique pur s'il contient un préfixe
                    const cleanId = item.id.includes('_') ? item.id.split('_')[1] : item.id;
                    window.location.href = "index.php?action=product&id=" + cleanId;
                };

                box.appendChild(div);
            });
        } catch (error) {
            console.error(error);
        }
    });

    // Helper de secours pour sécuriser les attributs JS HTML
    function htmlspecialchars_js(string) {
        return String(string).replace(/[&<>"']/g, function (s) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[s];
        });
    }
});
</script>

<?php $content = ob_get_clean(); ?>
<?php require('preset/layout.php'); ?>