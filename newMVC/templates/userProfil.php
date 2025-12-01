<?php
$title = "Page d'utilisateur";
// $style = "templates/style/style.css";
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

    <section id="profil">
        <div>
            <img src="./templates/images/profil-icon.png" alt="Logo du vendeur">
        </div>
        <h2><?= $u['firstname'] . " " . $u['name'] ?></h2>
    </section>

    <section id="stars">
        <img data-alt=<?= $score ?> id="starsImg" src="./templates/images/stars_design.png" alt="étoiles de notation">
        <div id="c1" style="width : <?= ($score * 100 / 5) . '%' ?>;"></div>
    </section>

    <section>
        <div class="content">
            <h1>Nos dernières annonces</h1>
            <div class="annonces">
                <?php if (empty($products)): ?>
                    <p>Aucune annonce disponible pour le moment.</p>
                <?php else: ?>
                    <?php for ($i = 0; $i < min(7, count($products)); $i++): ?>
                        <?php $p = $products[$i]; ?>
                        <div class="announce-card">
                            <?php
                            //$images = getImage($p['id_product']);
                            if (!empty($images)) {
                                echo '<img src="' . htmlspecialchars($images[0]['url_image']) . '" alt="Image annonce">';
                            } else {
                                echo '<div style="height:300px;display:flex;align-items:center;justify-content:center;">Aucune image disponible</div>';
                            }
                            ?>
                            <h3><?= htmlspecialchars($p['title']) ?></h3>
                            <!-- Timer -->
                            <p class="timer" data-end="<?= htmlspecialchars($p['end_date']) ?>"></p>
                            <a class="btn" href="index.php?action=product&id=<?= $p['id_product'] ?>">Voir</a>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
    </section>

</main>

<?php include('preset/footer.php'); ?>

<script>

    const div = document.querySelector("#stars");
    const img = div.querySelector('#starsImg');

    img.addEventListener("error", () => {
        const divs = div.querySelectorAll('div');

        for (let div of divs) {
            div.classList.add('isNotShow');
        }

        div.style.backgroundColor = "#F0F0F0";
        const score = img.dataset.alt;
        div.innerHTML = "<h3 style='text-align:center;'>" + score + "/5" + "</h3>"
    })


</script>
<?php $content = ob_get_clean(); ?>

<?php require('preset/layout.php'); ?>