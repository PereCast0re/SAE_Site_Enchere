<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>client</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <style>
        footer {
            position: absolute;
            bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <main>
        <?php
        if (!empty($_POST["email"]) && !empty($_POST["mdp"])) {
            echo "<p>Email : " . $_POST["email"] . "</p>";
            echo "<p>Mdp : " . $_POST["mdp"] . "</p>";
        } else {
            echo "<p>Le mail ou le mdp n'est pas valide.</p>";
        }
        ?>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>