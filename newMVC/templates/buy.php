<?php
/**
 * Vue : Page d'achats globale optimisée
 * Variables attendues du contrôleur : 
 * - $products : Array contenant les produits valides (avec clés 'celebrity_name' et 'images' incluses)
 */
$title = "Page d'achats";
$style = "templates/style/buy.css";
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<?php ob_start(); ?>

<?php include('preset/second-header.php'); ?>

    <main>
    <?php
    use App\Lib\DatabaseConnection;
    use App\Model\Repositories\ProductRepository;
    use App\Model\Repositories\UserRepository;

    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $productRepository = new ProductRepository($pdo);
    $products = $productRepository->getAllProduct();
    ?>

        <div class="search_bar" style="position: relative;"> <input type="text" id="searchInput" placeholder="Recherchez une annonce, une catégorie, une célébrité..." autocomplete="off">
        <button id="searchButton">Rechercher</button>
        <div id="suggestions" style="position: absolute; top: 100%; left: 0; width: 100%; max-height: 300px; overflow-y: auto; display: none; z-index: 10;"></div>
    </div>
    <?php
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);

    $products = $productRepository->getActiveFeaturedProducts(50);
    ?>

    <div class="content">
        <div
            class="annonces">
            <?php if (empty($products)): ?>
                <p>Aucune annonce disponible pour le moment.</p>
            <?php else: ?>
                <?php
                $count_displayed = 0;
                $max_to_display = 100;

                foreach ($products as $p):
                    if ($count_displayed >= $max_to_display)
                        break;

                    // Note : Le filtrage par date et statut (status == 1) doit idéalement être géré en amont dans le ProductRepository
                    if (new DateTime($p['end_date']) > new DateTime() && (isset($p['status']) && $p['status'] == 1)):
                        $imgUrl = !empty($p['images']) ? htmlspecialchars($p['images'][0]['url_image']) : 'templates/Images/default.png';
                        $celebrityName = $p['celebrity_name'] ?? 'N/A';
                        ?>
                        <div class="announce-card">
                            <div class="card-img-container">
                                <img src="<?= $imgUrl ?>" alt="Image annonce">
                            </div>

                            <div class="card-body">
                                <h3><?= htmlspecialchars($p['title']) ?></h3>
                                <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>

                                <div class="celebrity-row">
                                    <div class="avatar-wrapper">
                                        <img src="templates/Images/compte.png" class="celebrity-img" alt="Celebrity">
                                    </div>
                                    <span class="celebrity-name">Célébrité :
                                        <?= htmlspecialchars($celebrityName) ?>
                                    </span>
                                </div>

                                <div class="action-row">
                                    <button class="wishlist-btn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                    <a class="bid-btn" href="index.php?action=product&id=<?= urlencode($p['id_product']) ?>">Enchérir</a>
                                </div>
                            </div>
                        </div>
                        <?php $count_displayed++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($count_displayed === 0): ?><p>Aucune annonce active disponible pour le moment.
                </p>
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
const searchInput = document.getElementById('searchInput');
const suggestionsBox = document.getElementById('suggestions');
const announcementsContainer = document.querySelector('.annonces');
const searchButton = document.getElementById('searchButton');

// Initialisation globale des comptes à rebours
function initTimers() {
document.querySelectorAll('.timer').forEach(el => {
const endDate = el.getAttribute('data-end');
if (endDate && typeof startCountdown === 'function') 
startCountdown(endDate, el);

});
}
initTimers();

// 1. Suggestions à la saisie (Meilisearch Autocomplete)
searchInput.addEventListener('input', async function () {
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
const noResult = document.createElement('div');
noResult.style.padding = '8px';
noResult.style.color = '#555';
noResult.textContent = 'Aucun résultat';
suggestionsBox.appendChild(noResult);
return;
}

results.forEach(item => {
const div = document.createElement('div');
div.classList.add('suggestion-item');
div.style.padding = '8px';
div.style.cursor = 'pointer';
div.style.borderBottom = '1px solid #eee';
div.style.backgroundColor = '#fff';

let typeText = 'produit';
if (item.type === 'category') 
typeText = 'catégorie';
 else if (item.type === 'celebrity') 
typeText = 'célébrité';


div.textContent = `${
item.title
} dans ${typeText}`;

div.onclick = () => {
if (item.type === 'product') {
window.location.href = "index.php?action=product&id=" + item.product_id;
} else if (item.type === 'category') {
loadFilteredProducts("src/controllers/filterByCategory.php?id=" + item.category_id);
suggestionsBox.style.display = 'none';
searchInput.value = item.title;
} else if (item.type === 'celebrity') {
loadFilteredProducts("src/controllers/filterByCelebrity.php?id=" + item.celebrity_id);
suggestionsBox.style.display = 'none';
searchInput.value = item.title;
}
};
suggestionsBox.appendChild(div);
});
} catch (err) {
console.error(err);
}
});

// 2. Abstraction du chargement des filtres AJAX (Catégories / Célébrités)
async function loadFilteredProducts(url) {
announcementsContainer.innerHTML = '<p>Chargement des filtres...</p>';
try {
const response = await fetch(url);
const products = await response.json();
renderProductGrid(products);
} catch (err) {
console.error(err);
announcementsContainer.innerHTML = '<p>Erreur lors du filtrage des annonces.</p>';
}
}

// 3. Traitement de la recherche principale (Bouton et Touche Entrée)
async function performSearch() {
const q = searchInput.value.trim();
if (q.length === 0) 
return;


suggestionsBox.style.display = 'none';
announcementsContainer.innerHTML = '<p>Recherche en cours...</p>';

try {
const response = await fetch(`src/controllers/search.php?q=${
encodeURIComponent(q)
}`);
const hits = await response.json();

// Filtrer pour ne garder que les entités de type produit valides
const productsToDisplay = hits.filter(h => h.type === 'product' || h.id_product);
renderProductGrid(productsToDisplay);
} catch (err) {
console.error(err);
announcementsContainer.innerHTML = '<p>Erreur lors de la recherche.</p>';
}
}

searchButton.addEventListener('click', performSearch);
searchInput.addEventListener('keypress', (e) => {
if (e.key === 'Enter') 
performSearch();

});

// 4. Moteur de rendu sécurisé (Injection via Fragment DOM pour bloquer le XSS)
function renderProductGrid(productsList) {
announcementsContainer.innerHTML = '';

if (! productsList || productsList.length === 0) {
announcementsContainer.innerHTML = '<p>Aucune annonce trouvée.</p>';
return;
}

const fragment = document.createDocumentFragment();

productsList.forEach(p => {
const card = document.createElement('div');
card.classList.add('announce-card');

const imgUrl = (p.images && p.images.length > 0) ? p.images[0].url_image : 'templates/Images/default.png';
const secureTitle = document.createTextNode(p.title).textContent;
const secureCelebrity = document.createTextNode(p.celebrity_name || 'N/A').textContent;
const productId = p.id_product || p.product_id;

card.innerHTML = `
                    <div class="card-img-container">
                        <img src="${
encodeURI(imgUrl)
}" alt="Image annonce">
                    </div>
                    <div class="card-body">
                        <h3>${secureTitle}</h3>
                        <p class="timer" data-end="${
htmlspecialchars_js(p.end_date || '')
}"></p>
                        <div class="celebrity-row">
                            <div class="avatar-wrapper">
                                <img src="templates/Images/compte.png" class="celebrity-img" alt="Celebrity">
                            </div>
                            <span class="celebrity-name">Célébrité : ${secureCelebrity}</span>
                        </div>
                        <div class="action-row">
                            <button class="wishlist-btn">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <a class="bid-btn" href="index.php?action=product&id=${
parseInt(productId, 10)
}">Enchérir</a>
                        </div>
                    </div>
                `;
fragment.appendChild(card);
});

announcementsContainer.appendChild(fragment);
initTimers(); // Relance des comptes à rebours sur les nouveaux éléments injectés
}

function htmlspecialchars_js(string) {
return String(string).replace(/[&<>"']/g, function (s) {
return {
'&': '&amp;',
'<': '&lt;',
'>': '&gt;',
'"': '&quot;',
"'": '&#39;'
}[s];
});
}
});
</script>

<?php $content = ob_get_clean(); ?>
<?php require('preset/layout.php'); ?>
