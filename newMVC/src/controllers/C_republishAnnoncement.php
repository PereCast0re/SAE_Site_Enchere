<?php

require_once("src/model/product.php");
require_once('src/lib/database.php');

function republishAnnoncement($id_product){
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    $old_anoncement = $productRepository->getProduct($id_product);

    $start = new DateTime($old_anoncement['end_date']);
    $finish = new DateTime($old_anoncement['start_date']);
    $intervale = $start->diff($finish);

    $newStart = new DateTime();
    $nextFinish = clone $newStart;
    $nextFinish->add(new DateInterval('P' . $intervale->days . 'D'));
    
    //republishDatabase($old_anoncement['id_product'], $old_anoncement['title'], $old_anoncement['description'], $newStart, $nextFinish, $old_anoncement['reserve_price'], $old_anoncement['start_price'], $old_anoncement['status'], $old_anoncement['start_date'] );
}