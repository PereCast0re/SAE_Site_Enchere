<?php

use App\Lib\DatabaseConnection;
use App\Model\Repositories\ProductRepository;
use App\Model\Repositories\CelebrityRepository;

function deleteProductAdmin($id_product, $email_user, $username_user) {
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $celebrityRepositiory = new CelebrityRepository($pdo);

    // Récupération titre 
    $product = $productRepository->getProduct($id_product);
    $title = $product['title'];
    
    //Recupération avant suppression de l'annonce
    $categoryName = $productRepository->getCategoryFromAnnoncement($id_product);
    $celebrityName = $celebrityRepositiory->getCelebrityFromAnnoncement($id_product);

    //Annonce
    $productRepository->deleteProduct($id_product);

    //Cateogrie
    $productRepository->deleteCategory($id_product, $categoryName['name']);

    //Celebrity
    $celebrityRepositiory->deleteCelebrity($id_product, $celebrityName['name']);

    // email / nom / title
    $param = [$email_user, $username_user, $title];
    routeurMailing('refusalProductUser', $param);
}