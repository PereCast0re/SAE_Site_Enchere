<?php
$title = "Page d'utilisateur";
$style = "templates/style/user.css";
$script = "";

if (!isset($_SESSION['user'])) {
    header('location: index.php?action=connection');
    exit();
}

$user = $_SESSION['user'];
?>

<?php ob_start(); ?>
<!--<?php include('preset/header.php'); ?>-->
<link href="templates/style/stylePopup.css" rel="stylesheet" />

<div class="user-profile-container">
    <header class="profile-header">
        <h1>Vos informations personnelles   </h1>
        <div class="separator-line"></div>
    </header>

    <section class="section_info">
        <div class="info-group">
            <label>Nom</label>
            <div class="input-wrapper">
                <input type="text" name="name" placeholder="<?= htmlspecialchars(strip_tags($user['name'])) ?>" disabled>
                <button class="btn-modifier" type="button" onclick="ouvrirPopup('Name')">Modifier</button>
            </div>
        </div>

        <div class="info-group">
            <label>Prénom</label>
            <div class="input-wrapper">
                <input type="text" name="firstname" placeholder="<?= htmlspecialchars(strip_tags($user['firstname'])) ?>" disabled>
                <button class="btn-modifier" type="button" onclick="ouvrirPopup('FirstName')">Modifier</button>
            </div>
        </div>

        <div class="info-group">
            <label>Email</label>
            <div class="input-wrapper">
                <input type="mail" name="email" placeholder="<?= htmlspecialchars(strip_tags($user['email'])) ?>" disabled>
                <button class="btn-modifier" type="button" onclick="ouvrirPopup('Email')">Modifier</button>
            </div>
        </div>

        <div class="info-group">
            <label>Adresse</label>
            <div class="input-wrapper">
                <input type="text" name="address" id="addresse" placeholder="<?= htmlspecialchars(strip_tags($user['address'])) . ' ' . htmlspecialchars(strip_tags($user['postal_code'])) . ' ' . htmlspecialchars(strip_tags($user['city'])) ?>" disabled>
                <input type="hidden" id="city_hidden" value="<?= htmlspecialchars(strip_tags($user['city'])) ?>">
                <button class="btn-modifier" type="button" onclick="ouvrirPopup('Adresse')">Modifier</button>
            </div>
        </div>

        <div class="info-group">
            <label>Mot de passe</label>
            <div class="input-wrapper">
                <button class="btn-modifier" type="button" onclick="ouvrirPopup('Password')">Modifier</button>
            </div>
        </div>
    </section>

    <div id="popup"></div>

    <section class="annonces-section">
        <div class="wrapper-annonces">
            <div class="barre-noire"></div>
            <div class="section_annonce_publier annonce_list_container">
                <?php $annoncements = get_all_annoncement($user["id_user"]) ?>
                <input type="hidden" id="number_annoncement" name="action">
                <input type="hidden" id="values_annoncements" value='<?php echo htmlspecialchars(json_encode($annoncements, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, "UTF-8"); ?>'>
                <div class="stat_annonce"></div>
            </div>
        </div>

        <div class="wrapper-annonces">
            <div class="barre-noire"></div>
            <div id="div_end_annoncement_with_reserved" style="display: none;">
                <input type="hidden" id="id_user" value="<?php echo ($user["id_user"]) ?>">
            </div>
        </div>
    </section>

    <div class="Product_verif_admin" id="Product_verif_admin"></div>

    <a id="btn_historique_annonce_published" class="btn-history" href="index.php?action=historique_annonces_publiees">Voir l'historique de mes annonces</a>

    <div>
        <?php echo (republishAnnoncement(1)); ?>
    </div>

</div>

<script src="templates/JS/OuverturePopUp.js"></script>
<script src="templates/JS/timer.js"></script>
<script src="templates/JS/Annonce_publie_client.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>