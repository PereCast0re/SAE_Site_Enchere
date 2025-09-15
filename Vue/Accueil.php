<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>client</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <div class="swiper">
            <div class="swiper-wrapper">
                <!-- <?php foreach ($annonces as $a): ?>
                <div class="swiper-slide">
                    <img src="<?= htmlspecialchars($a['image']) ?>" alt="<?= htmlspecialchars($a['titre']) ?>">
                    <h3><?= htmlspecialchars($a['titre']) ?></h3>
                    <p>Prix actuel : <?= number_format($a['prix_actuel'], 2, ',', ' ') ?> €</p>
                </div>
                <?php endforeach; ?> -->
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>

        <h1>Nos dernières annonces</h1>

        <button id="Voir_annonces_btn">Voir les annonces</button>

        <p>------------------------------------------------------------------------------------</p>
        <button id="Connexion_button"><a href="connexion.php">Connexion</a></button>
        <button id="inscription_button"><a href="inscription.php">S'inscrire</a></button>

        <h1>Nos catégories en vedette</h1>
        <p>------------TEXTE------------</p>
        <button>BTN</Button>

    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>