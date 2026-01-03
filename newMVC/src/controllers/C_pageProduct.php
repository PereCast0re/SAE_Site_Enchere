<?php

require_once('src/lib/database.php');
require_once('src/model/comment.php');
require_once('src/model/favorite.php');

function Product($id_product)
{
    if (isset($id_product) && $id_product >= 0) {
        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $p = $productRepository->getProduct($id_product);
        if ($p === false)
            throw new Exception("This product doesn't exist !");

        $commentRepository = new CommentRepository($pdo);
        $comments = $commentRepository->getCommentsFromProduct($id_product);

        $current_price = $productRepository->getLastPrice($p['id_product'])['last_price'];
        $images = getImage($id_product);

        $favoriteRepository = new FavoriteRepository($pdo);
        $like = $favoriteRepository->getLikes($id_product)['nbLike'];
        if ($like === null) {
            $like = 0;
        }
        isset($_SESSION['user']) ? $isFav = $favoriteRepository->isProductFavorite($id_product, $_SESSION['user']['id_user']) : $isFav = false;

        require("templates/product.php");
    }
}

