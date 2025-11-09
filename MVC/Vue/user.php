<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: connection.php');
    exit();
}

$user = $_SESSION['user'];
include_once("../Controlleur/C_pageUser.php");
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
    <script src="../JS/timer.js"></script>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <?php
        echo "<p class='PsuedoClient'>" . $user['firstname'] . " " . $user['name'] . "</p>";
        ?>
    </main>

    <div class="section_info">
        <div class="nom_client">
            <p>Nom :</p>
            <input type="text" name="name" placeholder="<?php echo ($user['name']) ?>" disabled>
        </div>
        <div class="prenom_client">
            <p>Prenom :</p>
            <input type="text" name="firstname" placeholder="<?php echo ($user['firstname']) ?>" disabled>
        </div>
        <div class="email_client">
            <p>Email :</p>
            <input type="mail" name="email" placeholder="<?php echo ($user['email']) ?>" disabled>
            <button type="button" onclick="ouvrirPopup('Email')">Modifier</button>
        </div>
        <div class="adresse_client">
            <p>Adresse :</p>
            <input type="text" name="address"
                placeholder="<?php echo ($user['address'] . " " . $user['postal_code'] . " " . $user['city']) ?>"
                disabled>
            <button type="button" onclick="ouvrirPopup('Adresse')">Modifier</button>
        </div>
        <div class="mdp_client">
            <p>Mot de passe :</p>
            <input type="password" name="password" placeholder="<?php echo ($user['password']) ?>" disabled>
            <button type="button" onclick="ouvrirPopup('Password')">Modifier</button>
        </div>

        <div id="popup">
        </div>
        <div class="section_annonce_publier">
            <?php $annoncements = get_all_annoncement($user["id_user"]) ?>
            <input type="hidden" id="number_annoncement" name="action" >

            <!-- JSON_UNESCAPED_UNICODE can kept speical caracter like é JSON_UNESCAPED_SLASHES upgrade visualisation of json -->
            <input type="hidden" id="values_annoncements" value='<?php echo json_encode($annoncements, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>'>
        </div>

        <script src="../JS/OuverturePopUp.js"></script>
        <script src="../JS/Annonce_publie_client.js" defer></script>

        <footer>
            <?php include('footer.php'); ?>
        </footer>
</body>

</html>