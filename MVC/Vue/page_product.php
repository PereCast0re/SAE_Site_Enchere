<?php
require_once("../Modele/pdo.php");
include('../Controlleur/C_pageProduct.php');

session_start();
$user = $_SESSION['user'];
$id_annoncement = $_GET['id'];
$annoncement = getAnnoncement($id_annoncement);
var_dump($annoncement);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo($annoncement['title']); ?></h1>
    <p><?php echo($annoncement['description']); ?></p>
</body>
</html>