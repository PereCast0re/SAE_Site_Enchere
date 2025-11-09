<?php
require_once("../Modele/pdo.php");
require_once('../Controlleur/C_pageProduct.php');

session_start();
$user = $_SESSION['user'];
$id_annoncement = $_GET['id'];
$annoncement = getAnnoncement($id_annoncement);
var_dump($annoncement);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button class="fav_btn" id="fav_btn" style="background-color: light-grey;" >⭐</button>
    <h1><?php echo($annoncement['title']); ?></h1>
    <p><?php echo($annoncement['description']); ?></p>
</body>

    <script src="../JS/Page_product.js"></script>
</html>