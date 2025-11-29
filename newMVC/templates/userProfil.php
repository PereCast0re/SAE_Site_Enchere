<?php
$title = "Page d'utilisateur";
$style = "templates/style/style.css";
$optional_style1 = "templates/style/userProfil.css"
    ?>

<?php ob_start(); ?>
<header>
    <?php include('preset/header.php'); ?>
</header>

<main>

    <?php
    echo "<p class='PsuedoClient'>" . $u['firstname'] . " " . $u['name'] . "</p>";
    ?>
    <div id="stars">
        <img src="./templates/images/stars_design.png">
        <div id="c1"></div>
        <div id="c2"></div>
    </div>
</main>

<footer>
    <?php include('preset/footer.php'); ?>
</footer>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>