<?php
$title = "Page d'inscription'";
$style = "templates/style/Accueil.css";
?>

<?php ob_start(); ?>

<?php include('preset/header.php'); ?>

<main>
    <section class="inscription">
        <hr>
        <h1>Inscrivez-vous.</h1>
        <form action="index.php?action=userInscription" method="post" id="connexion">
            <div>
                <label for="inscription-name">Nom</label>
                <input type="text" id="inscription-name" name="name" placeholder="Nom">
            </div>
            <div>
                <label for="inscription-firstname">Prenom</label>
                <input type="text" id="inscription-firstname" name="firstname" placeholder="Prenom">
            </div>
            <div>
                <label for="inscription-birtdate">Date de naissance</label>
                <input type="date" id="inscription-birtdate" name="birth_date">
            </div>
            <div>
                <label for="inscription-address">Adresse</label>
                <input type="text" id="inscription-address" name="address" placeholder="Adresse">
            </div>
            <div>
                <label for="inscription-city">Ville</label>
                <input type="text" id="inscription-city" name="city" placeholder="Ville">
            </div>
            <div>
                <label for="inscription-postalCode">Code postal</label>
                <input type="number" id="inscription-postalCode" name="postal_code" placeholder="Code postal">
            </div>
            <div>
                <label for="inscription-email">Email</label>
                <input type="text" id="inscription-email" name="email" placeholder="Email">
            </div>
            <div>
                <label for="inscription-password">Mot de passe</label>
                <input type="password" id="inscription-password" name="password" placeholder="Mot de passe">
            </div>

            <br>
            <input type="submit" value="Inscription">
        </form>
        <hr>
    </section>
</main>

<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php');