<?php

require_once('src/lib/database.php');
require_once('src/model/product.php');

function get_all_annoncement($id_user){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $tab_annoncements = $productRepository->get_Annonce_User($id_user);
    return $tab_annoncements;
}

