<?php

require_once(__DIR__ . '/../lib/database.php');
require_once(__DIR__ . '/../model/product.php');
require_once(__DIR__ . '/../model/celebrity.php');

function UpdateProduct($id_product){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $celebrityRepositiory = new CelebrityRepository($pdo);

}