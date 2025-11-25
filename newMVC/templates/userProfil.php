<?php
$title = "Page d'utilisateur";
$style = "templates/style/style.css";
?>

<?php ob_start(); ?>
    <header>
        <?php include('preset/header.php'); ?>
    </header>

    <main>
        
        <?php
        echo "<p class='PsuedoClient'>" . $u['firstname'] . " " . $u['name'] . "</p>";
        ?>
    </main>
        <footer>
            <?php include('preset/footer.php'); ?>
        </footer>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>