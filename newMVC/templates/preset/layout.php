<?php

if (isset($_SESSION['user'])){
    UserCheckConnexion($_SESSION['user']['DateConnexion']);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?> </title>
    <link href="<?= $style ?>" rel="stylesheet">

    <script src="<?= empty($script) ? "" : $script ?>" defer></script>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>

<body>
    <?= $content ?>
    <?php include 'templates/preset/loginModal.php'; ?>
    <?php include 'templates/preset/signinModal.php'; ?>
    <?php include 'templates/preset/subscribeModal.php'; ?>
</body>

</html>