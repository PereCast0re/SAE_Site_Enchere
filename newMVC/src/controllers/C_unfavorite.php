<?php

require_once("src/model/favorite.php");
require_once("src/lib/database.php");

function unfavorite()
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

        $pdo = DatabaseConnection::getConnection();
        $favoriteRepository = new FavoriteRepository($pdo);
        if (!($favoriteRepository->isProductFavorite($id_product, $id_user)))
            exit;

        $success = $favoriteRepository->unsetProductFavorite($id_product, $id_user);
        if (!$success)
            throw new Exception("You can't unfavorite this product !");
    } else {
        throw new Exception("Les informations pour enlever en favoris l'annonce a échoué !");
    }
}