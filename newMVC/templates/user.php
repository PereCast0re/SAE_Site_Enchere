<?php
$title = "Page d'utilisateur";
$style = "templates/style/Accueil.css";
$script = "";

if (!isset($_SESSION['user'])) {
    header('location: index.php?action=connection');
    exit();
}

$user = $_SESSION['user'];
?>

<?php ob_start(); ?>
<?php include('preset/header.php'); ?>
<link href="templates/style/stylePopup.css" rel="stylesheet" />

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
            placeholder="<?php echo ($user['address'] . " " . $user['postal_code'] . " " . $user['city']) ?>" disabled>
        <button type="button" onclick="ouvrirPopup('Adresse')">Modifier</button>
    </div>
    <div class="mdp_client">
        <p>Mot de passe :</p>
        <input type="password" name="password" placeholder="<?php echo ($user['password']) ?>" disabled>
        <button type="button" onclick="ouvrirPopup('Password')">Modifier</button>
    </div>

        <div id="popup">
        </div>
        <div class="wrapper-annonces">
            <div class="barre-noire"></div>
            <div class="section_annonce_publier">
                <?php $annoncements = get_all_annoncement($user["id_user"]) ?>
                <input type="hidden" id="number_annoncement" name="action" >

                <!-- JSON_UNESCAPED_UNICODE can kept speical caracter like é JSON_UNESCAPED_SLASHES upgrade visualisation of json -->
                <input type="hidden" id="values_annoncements" value='<?php echo htmlspecialchars(json_encode($annoncements, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, "UTF-8"); ?>'>        
            </div>
        </div>
        <div class="stat_annonce">
        </div>
        
        <div class="wrapper-annonces">
            <div class="barre-noire"></div>
            <div id="div_end_annoncement_with_reserved" style="display: none;">
                <input type="hidden" id="id_user" value="<?php echo ($user["id_user"]) ?>" >
            </div>
        </div>

        
        <div class="wrapper-annonces">
            <div class="barre-noire"></div>
            <div id="div_historique_annoncement" style="display: none;">
            </div>
        </div>
        <br>
        <a class="btn" style="margin-top: 20px;" href="index.php?action=historique_annonces_publiees">Voir l'historique de mes annonces</a>

        <div>
            <?php echo(republishAnnoncement(1)); ?>
        </div>
        </div>

    <div>
        <?php echo (republishAnnoncement(1)); ?>
    </div>
</div>

<script src="templates/JS/OuverturePopUp.js"></script>
<script src="templates/JS/timer.js"></script>
<script src="templates/JS/Annonce_publie_client.js" defer></script>

<!-- Appel script api pour les graphes -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include('preset/footer.php'); ?>

<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>