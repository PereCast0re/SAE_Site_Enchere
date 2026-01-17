<?php
$title = "Erreur";
$style = "templates/style/error.css";
?>

<?php ob_start(); ?>

<script src="https://kit.fontawesome.com/645d3e5fd2.js" crossorigin="anonymous" defer></script>

<div>
    <h2>
        <?= $errorMessage ?>
    </h2>
    <a href="index.php">Cliquez ici pour revenir</a>
    <p>Redirection en cours...</p>
</div>

<script>
    setTimeout(() => {
        window.location.href = "index.php";
    }, 5000);
</script>

<?php $content = ob_get_clean() ?>

<?php require('layout.php'); ?>