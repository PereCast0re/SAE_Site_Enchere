<?php
$title = "Page d'utilisateur";
// $style = "templates/style/style.css";
$style = "templates/style/userProfil.css";
?>

<?php ob_start(); ?>

<style>
    footer {
        position: absolute;
        bottom: 0;
    }
</style>

<header>
    <?php include('preset/header.php'); ?>
</header>

<main>

    <section id="profil">
        <div>
            <img src="./Annonce/eee/eee_1.jpg" alt="Logo du vendeur">
        </div>
        <h2><?= $u['firstname'] . " " . $u['name'] ?></h2>
    </section>

    <section id="stars">
        <img data-alt=<?= $score ?> id="starsImg" src="./templates/images/stars_design.png" alt="étoiles de notation">
        <div id="c1" style="width : <?= ($score*100 / 5). '%' ?>;"></div>
    </section>

</main>

<footer>
    <?php include('preset/footer.php'); ?>
</footer>

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