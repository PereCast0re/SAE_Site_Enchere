<?php
require(dirname(__DIR__, 2) . '/src/script/verif_online_annoncement.php');
?>

<link rel="stylesheet" href="templates/Style/second-header.css">


<header>
    <nav>
        <a id="header-logo" href="index.php">
            <img src="templates/images/logo.png" alt="Logo">
        </a>

        <div class="burger-menu" id="burger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div id="header-links">
            <ul>
                <li>
                    <a href="index.php?action=buy">Acheter</a>
                </li>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li>
                        <a href="index.php?action=sell">Vendre</a>
                    </li>
                <?php } ?>
                <?php if (isset($_SESSION['user']['admin']) && $_SESSION['user']['admin'] != 0) { ?>
                    <li>
                        <a href="index.php?action=admin">Panneau Admin</a>
                    </li>
                <?php } ?>
            </ul>

            <ul>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li>
                        <a href="index.php?action=historique_annonces_publiees">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=getLikes">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=user">
                            <i class="fa-solid fa-star"></i>
                        </a>
                    </li>
                <?php } ?>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li>
                        <a class="header-btn" href="index.php?action=deconnexion">Déconnexion</a>
                    </li>
                <?php } ?>
                <?php if (!isset($_SESSION['user'])) { ?>
                    <li>
                        <a class="header-btn" href="index.php?action=connection">Connexion</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>

<script src="https://kit.fontawesome.com/645d3e5fd2.js" crossorigin="anonymous"></script>

<script>
    const burgerMenu = document.getElementById('burger-menu');
    const headerLinks = document.getElementById('header-links');

    burgerMenu.addEventListener('click', () => {
        burgerMenu.classList.toggle('active');
        headerLinks.classList.toggle('active');
    });

    // Ferme le menu quand on clique sur un lien
    const links = headerLinks.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', () => {
            burgerMenu.classList.remove('active');
            headerLinks.classList.remove('active');
        });
    });
</script>