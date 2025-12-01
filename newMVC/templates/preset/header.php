<header>
    <nav>
        <ul>
            <li><a href="">Acheter</a></li>
            <?php if (isset($_SESSION['user'])) { ?>
                <li><a id="btn_vente" href="index.php?action=sell">Vendre</a></li>
                <li><a id="btn_client" href="index.php?action=user">Client</a></li>
            <?php } ?>
        </ul>
        <a href="index.php">
            <img src="" alt="logo">
        </a>
        <a id="btn_connexion" href="index.php?action=connection">Connexion</a>
    </nav>
</header>