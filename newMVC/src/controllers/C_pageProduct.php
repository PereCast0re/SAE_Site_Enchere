<?php

require_once('src/lib/database.php');
require_once('src/model/comment.php');
require_once('src/model/favorite.php');
require_once("src/controllers/C_counterView.php");

function Product($id_product)
{
    if (isset($id_product) && $id_product >= 0) {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $p = $productRepository->getProduct($id_product);
        if ($p === false)
            throw new Exception("This product doesn't exist !");

        AddNewView($p);

        $commentRepository = new CommentRepository($pdo);
        $comments = $commentRepository->getCommentsFromProduct($id_product);

        $category = $productRepository->getCategoryFromAnnoncement($id_product);
        // var_dump($category);
        $current_price = $productRepository->getLastPrice($p['id_product'])['last_price'];
        if ($current_price === null) {
            $current_price = $p['start_price'];
        }

        $reservePrice = (int)$p["reserve_price"];
        // var_dump($reservePrice);

        $images = getImage($id_product);

        $extensions_valides = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $images = array_filter($images, function ($img) use ($extensions_valides) {
            $ext = strtolower(pathinfo($img['url_image'], PATHINFO_EXTENSION));
            return in_array($ext, $extensions_valides);
        });

        $certificate = array_filter($images, function ($img) {
            $ext = strtolower(pathinfo($img['url_image'], PATHINFO_EXTENSION));
            return $ext === "pdf";
        });

        $certificate = array_values($certificate);

        $favoriteRepository = new FavoriteRepository($pdo);
        $like = $favoriteRepository->getLikes($id_product)['nbLike'];
        if ($like === null) {
            $like = 0;
        }
        isset($_SESSION['user']) ? $isFav = $favoriteRepository->isProductFavorite($id_product, $_SESSION['user']['id_user']) : $isFav = false;

        $price_ex = [];
        for ($i = 0; $i < 3; $i++) {
            array_push($price_ex, $i == 0 ? $current_price + addToPrice($current_price) : $price_ex[$i - 1] + addToPrice($price_ex[$i - 1]));
        }

        require("templates/product.php");
    }
}

function addToPrice($currentPrice) {
    if ($currentPrice < 100) return 5;
    else if ($currentPrice < 500) return 10;
    else if ($currentPrice < 1000) return 20;
    else if ($currentPrice < 5000) return 50;
    else if ($currentPrice < 10000) return 100;
    else if ($currentPrice < 50000) return 500;
    return 1000;
}
