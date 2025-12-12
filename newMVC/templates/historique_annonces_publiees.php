<?php
$title = "Historique des annonces publiées";
$style = "templates/style/Accueil.css";

$user = $_SESSION['user'];
?>

<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chemin correct depuis templates/ vers src/model/pdo.php
require_once __DIR__ . '/../src/model/pdo.php';



$id_client = $user['id_user'];
$annonces = get_termined_annonces_by_client($id_client);
$annonces_en_cours = get_actual_annonces_by_client($id_client);
?>
<main>
<div class="Annonces_en_cours">
    <h1>Mes enchères en cours</h1>
    <?php if (empty($annonces_en_cours)): ?>
        <p>Vous n'avez aucune annonce en cours.</p>
    <?php endif; ?>
    <div class="Annonces-list-cards">
        <?php foreach ($annonces_en_cours as $a): ?>
            <div class="card">
                <!--- image --->
            <h3>
                <?= htmlspecialchars($a['titre']) ?>
            </h3>
            <!--- Timer --->
            <p class="timer" data-end="<?= htmlspecialchars($a['end_date']) ?>"></p>
            <p>Prix actuel :
                <?php
                // get_price_annoncement retourne un array (fetchAll). On convertit en valeur string.
                $priceRow = get_price_annoncement($a['id_product']);
                $current_price = null;
                if (!empty($priceRow) && isset($priceRow[0]['MAX(new_price)']) && $priceRow[0]['MAX(new_price)'] !== null) {
                    $current_price = $priceRow[0]['MAX(new_price)'];
                } else {
                    // fallback si pas d'enchère : utiliser reserve_price si présent ou "0"
                    $current_price = isset($a['reserve_price']) ? $a['reserve_price'] : '0';
                }
                echo htmlspecialchars($current_price);
                ?> €
            </p>
            <a class="btns" id="voir"  href="index.php?action=product&id=<?= $a['id_product'] ?>">Voir</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="Historique_annonces">
    <h2>Mes enchères terminées</h2>
    <div class="Annonces-list-cards">

        <?php foreach ($annonces as $a): ?>
        <div class="card">
            <!--- image --->
            <h3>
                <?= htmlspecialchars($a['titre']) ?>
            </h3>
            <p>Prix actuel :
                <?php
                // Même logique que pour les annonces en cours : convertir le résultat de get_price_annoncement en valeur
                $priceRow = getLastPrice($a['id_product']);
                $current_price = null;
                if (!empty($priceRow) && isset($priceRow[0]['MAX(new_price)']) && $priceRow[0]['MAX(new_price)'] !== null) {
                    $current_price = $priceRow[0]['MAX(new_price)'];
                } else {
                    $current_price = isset($a['reserve_price']) ? $a['reserve_price'] : '0';
                }
                echo htmlspecialchars($current_price);
                ?> €
            </p>
            <button id="valider">Valider</button>
            <a href="index.php?action=product&id<?= $a['id_product'] ?>">voir</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</main>


<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

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
<?php require('preset/layout.php');