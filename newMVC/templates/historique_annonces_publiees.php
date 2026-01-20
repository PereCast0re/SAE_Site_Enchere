<?php
$title = "Historique des annonces publiées";
$style = "templates/style/historique.css";

$user = $_SESSION['user'];
?>

<?php ob_start(); ?>


<?php include('preset/second-header.php'); ?>

<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chemin correct depuis templates/ vers src/model/pdo.php
require_once __DIR__ . '/../src/model/pdo.php';
require_once('src/model/product.php');
require_once('src/lib/database.php');



$id_client = $user['id_user'];
?>
<main>
<div class="Historique_annonces">
    <input type="hidden" id="id_user" value="<?= htmlspecialchars(strip_tags($id_client)) ?>">
        <div class="Annonces-list-cards" id="historique_product"></div>

</div>
</main>

<script src="templates/JS/Historique_product.js"></script>

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