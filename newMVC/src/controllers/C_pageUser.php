<?php

use App\Lib\DatabaseConnection;
use App\Model\Repositories\ProductRepository;

function get_all_annoncement($id_user){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $tab_annoncements = $productRepository->get_Annonce_User($id_user);
    return $tab_annoncements;
}

