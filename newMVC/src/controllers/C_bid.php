<?php

require_once("src/model/pdo.php");

function bid($id_product, $id_user, $newPrice)
{
    $currentPrice = (int)getLastPrice($id_product);
    if ($newPrice > $currentPrice)
        echo ("This price is under the current price. Impossible to bid !");

    $success = bidProduct($id_product, $id_user, $newPrice);
    if (!$success)
        throw new Exception("You can't bid this product !");
}