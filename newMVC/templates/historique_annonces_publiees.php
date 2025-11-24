<?php
$title = "Historique des annonces publiées";
$style = "templates/style/style.css";

$user = $_SESSION['user'];
?>

<?php ob_start(); ?>
<header>
    <?php include('preset/header.php'); ?>
</header>

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
<div class="Annonces_en_cours">
    <h2>Mes enchères en cours</h2>
    <div class="Annonces-list-cards">
        <?php foreach ($annonces_en_cours as $a): ?>
            <div class="card">
                <!--- image --->
            <h3>
                <?= htmlspecialchars($a['titre']) ?>
            </h3>
            <!--- Timer --->
            <p>Prix actuel :
                <?= htmlspecialchars($a['prix_en_cours']) ?> €
            </p>
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
                <?= htmlspecialchars($a['prix_en_cours']) ?> €
            </p>
            <button id="valider">Valider</button>
            <button>voir</button>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    <?php include('preset/footer.php'); ?>
</footer>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php');