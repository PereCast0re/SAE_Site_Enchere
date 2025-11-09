<?php

require_once("../Modele/pdo.php");

if(isset($_GET["action"]) && isset( $_GET["id_product"])){
    $action = $_GET["action"];
    $id_annoncement = $_GET["id_product"];
}

if ($action == "load_product"){
    header("Location: ../Vue/page_product.php?id=" .$id_annoncement);
}