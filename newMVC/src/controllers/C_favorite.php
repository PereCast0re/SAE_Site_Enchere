<?php

require_once("src/model/pdo.php");

function favorite($id_product, $id_user)
{
    if (isProductFavorite($id_product, $id_user))
        exit;

    $success = setProductFavorite($id_product, $id_user);
    if (!$success)
        throw new Exception("You can't favorite this product !");
}