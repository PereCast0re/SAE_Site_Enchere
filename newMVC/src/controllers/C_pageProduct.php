<?php

function Product($id_product)
{
    if (isset($id_product) && $id_product >= 0) {
        $p = getProduct($id_product);
        if ($p === false)
            throw new Exception("This product doesn't exist !");

        $comments = getCommentsFromProduct($id_product);
        $current_price = getLastPrice($p['id_product'])['last_price'];
        $images = getImage($id_product);
        isset($_SESSION['user']) ? $isFav = isProductFavorite($id_product, $_SESSION['user']['id_user']) : $isFav = false;

        require("templates/product.php");
    }
}

