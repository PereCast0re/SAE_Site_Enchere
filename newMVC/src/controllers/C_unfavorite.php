<?php

require_once("src/model/pdo.php");

function unfavorite($id_product, $id_user)
{
    if (!isProductFavorite($id_product, $id_user))
        exit;

    $success = unsetProductFavorite($id_product, $id_user);
    if (!$success)
        throw new Exception("You can't unfavorite this product !");
}