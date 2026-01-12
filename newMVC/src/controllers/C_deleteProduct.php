<?php

require_once(__DIR__ . '/../lib/database.php');
require_once(__DIR__ . '/../model/product.php');
require_once(__DIR__ . '/../model/celebrity.php');

function deleteProductAdmin($id_product){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $celebrityRepositiory = new CelebrityRepository($pdo);
    
    //Recupération avant suppression de l'annonce
    $categoryName = $productRepository->getCategoryFromAnnoncement($id_product);
    $celebrityName = $celebrityRepositiory->getCelebrityFromAnnoncement($id_product);

    //Annonce
    $productRepository->deleteProduct($id_product);

    //Cateogrie
    $productRepository->deleteCategory($id_product, $categoryName['name']);

    //Celebrity
    $celebrityRepositiory->deleteCelebrity($id_product, $celebrityName['name']);

}