<?php
$title = "Page de connexion";
$style = "templates/style/Accueil.css";
?>

<?php ob_start(); ?>
<style>
    footer {
        position: absolute;
        bottom: 0;
    }
</style>


<?php include('preset/header.php'); ?>

<main>
    <section class="connection">
        <hr>
        <h1>Connectez-vous à votre compte.</h1>
        <form action="index.php?action=userConnection" method="post" id="connexion">
            <div>
                <label for="connection-email">Email</label>
                <input type="text" id="connection-email" name="email" placeholder="Email">
            </div>
            <div>
                <label for="connection-password">Mot de passe</label>
                <input type="password" id="connection-password" name="password" placeholder="Mot de passe">
            </div>

            <br>
            <input type="submit" value="Connexion">
        </form>
        <p>Vous n'avez pas encore de compte, inscrivez-vous dès maintenant en cliquant <a
                href="index.php?action=inscription">ici</a></p>
        <hr>
    </section>
</main>

<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>