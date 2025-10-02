<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>accueil</title>
    <link rel="stylesheet" href="Style/style.css">
    <script src="" defer></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <div>
            <div class="swiper">
                <?php
                include_once('../Modele/pdo.php');
                $annonces = array(); // Initialisation du tableau des annonces
                $annonces = get_annonces_with_images(); // Récupération des annonces avec images
                ?>
                <?php if (empty($annonces)): ?>
                    <p>Aucune annonce disponible pour le moment.</p>
                <?php endif; ?>
                <div class="swiper-wrapper">
                    <?php foreach ($annonces as $a): ?>
                    <div class="swiper-slide">
                        <img src="<?= htmlspecialchars($a['image']) ?>" alt="<?= htmlspecialchars($a['titre']) ?>">
                        <h3><?= htmlspecialchars($a['titre']) ?></h3>
                        <p>Prix actuel : <?= number_format($a['prix_actuel'], 2, ',', ' ') ?> €</p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>

            <h1>Nos dernières annonces</h1>

            <a id="Voir_annonces_btn" class="btn">Voir les annonces</a>

            <p>------------------------------------------------------------------------------------</p>
            <a id="Connexion_button" class="btn" href="connexion.php">Connexion</a>
            <br>
            <a id="inscription_button" class="btn" href="inscription.php">S'inscrire</a>

            <h1>Nos catégories en vedette</h1>
            <p>------------TEXTE------------</p>
            <a class="btn">BTN</a>
            <br>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>