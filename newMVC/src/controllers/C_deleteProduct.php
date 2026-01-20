<?php

require_once(__DIR__ . '/../lib/database.php');
require_once(__DIR__ . '/../model/product.php');
require_once(__DIR__ . '/../model/celebrity.php');
require_once('C_emailing.php');

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