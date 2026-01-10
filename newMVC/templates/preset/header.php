<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="templates/Style/header.css">



<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">
                <img src="templates/images/logo.png" alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a id="btn_achat" class="nav-link" href="index.php?action=buy">Acheter</a>
                    </li>

                    <?php if (isset($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <a id="btn_vente" class="nav-link" href="index.php?action=sell">Vendre</a>
                        </li>
                    <?php } ?>
                    <?php if (isset($_SESSION['user']['admin']) && $_SESSION['user']['admin'] != 0) { ?>
                        <li class="nav-item">
                            <a id="btn_admin" class="nav-link" href="index.php?action=admin">Panneau Admin</a>
                        </li>
                    <?php } ?>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <a id="btn_Favoris" class="nav-link" href="index.php?action=getLikes">
                                <img src="templates/images/coeur.png" alt="Favoris" style="width: 30px; height: 30px;">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="btn_client" class="nav-link" href="index.php?action=user">
                                <img src="templates/images/compte.png" alt="Client" style="width: 30px; height: 30px;">
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <a id="btn_deconnexion" class="nav-link" href="index.php?action=deconnexion">Déconnexion</a>
                        </li>
                    <?php } ?>
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <a id="btn_connexion" class="nav-link" href="index.php?action=connection">Connexion</a>
                        </li>
                    <?php } ?>
                </ul>

            </div>

        </div>
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>