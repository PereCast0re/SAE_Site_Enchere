<?php

require_once("src/model/pdo.php");
require_once("src/model/bid.php");
require_once("src/lib/database.php");

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

        $pdo = DatabaseConnection::getConnection();
        $bidRepository = new BidRepository($pdo);
        $id_last_bidder = $bidRepository->getLastBidder($id_product);

        $productDate = $bidRepository->getProductDate($id_product);
        $now = time();

        $endTimestamp = strtotime($productDate);
        $remaining = $endTimestamp - $now;

        // echo $productDate, $endTimestamp, $now, $remaining;

        if ($remaining <= 0) {
            echo "finished";
            exit;
        }

        if ($id_user === $id_last_bidder) {
            echo "user_not_accepted";
            exit;
        }

        $currentPrice = (int) getLastPrice($id_product)['last_price'];
        if ($newPrice <= $currentPrice) {
            echo "price_not_accepted";
            exit;
        }

        $success = $bidRepository->bidProduct($id_product, $id_user, $newPrice);
        if (!$success) {
            echo "not_available";
            exit;
        }

        // ajouter 30s de plus pour éviter d'enchérir au dernier moment
        if ($remaining >= 0 && $remaining <= 30) {
            $bidRepository->addTime($id_product);
            echo "time_extended";
            exit;
        }

        echo "success";
        exit;
    }
}