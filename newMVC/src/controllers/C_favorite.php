<?php

require_once("src/model/pdo.php");

function favorite()
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

        if (isProductFavorite($id_product, $id_user))
            exit;

        $success = setProductFavorite($id_product, $id_user);
        if (!$success)
            throw new Exception("You can't favorite this product !");
    } else {
        throw new Exception("Les informations pour mettre en favoris l'annonce a échoué !");
    }
}