<?php

require_once("src/model/pdo.php");

function bid()
{
    if (isset($_GET['id']) && $_GET['id'] >= 0) {
        if (!isset($_SESSION['user'])) {
            // Utilisateur non connecté
            http_response_code(401); // optionnel, HTTP Unauthorized
            echo "not_logged";
            exit;
        }

        $id_product = $_GET['id'];
        $id_user = $_SESSION['user']['id_user'];
        $newPrice = (int) $_POST['newPrice'];

        $currentPrice = (int) getLastPrice($id_product);
        if ($newPrice > $currentPrice)
            echo ("This price is under the current price. Impossible to bid !");

        $success = bidProduct($id_product, $id_user, $newPrice);
        if (!$success)
            throw new Exception("You can't bid this product !");
    }
}