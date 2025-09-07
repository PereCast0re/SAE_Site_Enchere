<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <div>
            <hr>
            <h1>Connectez-vous à votre compte.</h1>
            <section id="connexion">
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
            </section>
            <p>Vous n'avez pas encore de compte, inscrivez-vous dès maintenant en cliquant <a href="inscription.php">ici</a></p>
            <hr>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>