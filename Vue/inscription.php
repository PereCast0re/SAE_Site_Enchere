<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="" defer></script>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <div>
            <hr>
            <h1>Inscrivez-vous.</h1>
            <form action="client.php" method="post" id="connexion">
                <div>
                    <h2>Nom</h2>
                    <input type="text" name="nom" placeholder="Nom">
                </div>
                <div>
                    <h2>Prenom</h2>
                    <input type="text" name="prenom" placeholder="Prenom">
                </div>
                <div>
                    <h2>Date de naissance</h2>
                    <input type="date" name="naissance">
                </div>
                <div>
                    <h2>Adresse</h2>
                    <input type="text" name="adresse" placeholder="Adresse">
                </div>
                <div>
                    <h2>Ville</h2>
                    <input type="text" name="ville" placeholder="Ville">
                </div>
                <div>
                    <h2>Code postal</h2>
                    <input type="number" name="code_postal" placeholder="Code postal">
                </div>
                <div>
                    <h2>Email</h2>
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div>
                    <h2>Mot de passe</h2>
                    <input type="password" name="mdp" placeholder="Mot de passe">
                </div>

                <br>
                <input type="submit" value="Connexion">
            </form>
            <hr>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>