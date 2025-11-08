<?php
session_start();

if (!isset($_SESSION['client'])) {
    header('location: connexion.php');
    exit();
}

$client = $_SESSION['client'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace client</title>
    <link rel="stylesheet" href="Style/style.css">
    <script src="script.js" defer></script>
    <style>
        footer {
            position: absolute;
            bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <?php
        echo "<p class='PsuedoClient'>" . $client['nom'] . " " . $client['prenom'] . "</p>";
        ?>
    </main>

    <div class="section_info">
        <div class="nom_client">
            <p>Nom :</p>
            <input type="text" name="nom" placeholder="<?php echo ($client['nom']) ?>" disabled>
        </div>
        <div class="prenom_client">
            <p>Prenom :</p>
            <input type="text" name="prenom" placeholder="<?php echo ($client['prenom']) ?>" disabled>
        </div>
        <div class="email_client">
            <p>Email :</p>
            <input type="mail" name="email" placeholder="<?php echo ($client['email']) ?>" disabled>
            <button type="button" onclick="ouvrirPopup('Email')">Modifier</button>
        </div>
        <div class="adresse_client">
            <p>Adresse :</p>
            <input type="text" name="adresse"
                placeholder="<?php echo ($client['adresse'] . " " . $client['code_postale'] . " " . $client['ville']) ?>"
                disabled>
            <button type="button" onclick="ouvrirPopup('Adresse')">Modifier</button>
        </div>
        <div class="mdp_client">
            <p>Mot de passe :</p>
            <input type="password" name="password" placeholder="<?php echo ($client['mdp']) ?>" disabled>
            <button type="button" onclick="ouvrirPopup('Password')">Modifier</button>
        </div>
        <div>

        <div id="popup">
        </div>

        <div class="section_annonce_publier">
            <input type="hidden" name="action" >
        </div>

        <script src="../JS/OuverturePopUp.js"></script>
        <script src="../JS/Annonce_publie_client.js"></script>

            <footer>
                <?php include('footer.php'); ?>
            </footer>
</body>

</html>