<?php

require_once("src/model/product.php");
require_once('src/lib/database.php');
require_once('C_emailing.php');

function acceptReservedPrice($data, $id_user){
    if (isset($data['id_product'])) {
        $id_product = $data['id_product'];

        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $succes = $productRepository->updateReservePrice($id_product);
        if ($succes){
            $product = $productRepository->getProduct($id_product);
            // 0
            $email = $id_user['email'];
            // 1 name
            $name = $id_user['name'] . ' ' . $id_user['firstname'];
            // 2
            $titleProduct = $product['title'];
            // 3 name buyer
            $buyer = $productRepository->getBuyer($id_product);
            $nameBuyer = $buyer['name'] . ' ' . $buyer['firstname'];
            // 4 email buyer 
            $emailBuyer = $buyer['email'];

            $paramSeller = [$email, $name, $titleProduct, $nameBuyer, $emailBuyer];
            $paramBuyer = [$emailBuyer, $nameBuyer, $titleProduct];
            routeurMailing('acceptReservedPrice', $paramSeller);
            routeurMailing('acceptReservedBuyer', $paramBuyer);
        }
    } else {
        throw new Exception("ID de produit invalide pour accepter le prix réservé.");
    }
}

function refuseReservedPrice($data, $id_user){
    if (isset($data['id_product'])) {
        $id_product = $data['id_product'];

        $pdo = DatabaseConnection::getConnection();
        $productRepository = new ProductRepository($pdo);
        $succes = $productRepository->updateReservePrice($id_product);
        if ($succes){
            $product = $productRepository->getProduct($id_product);
            // 0
            $email = $product['seller_email'];
            // 1 name
            $name = $product['seller_name'] . ' ' . $product['seller_firstname'];
            // 2
            $titleProduct = $product['title'];

            $paramSeller = [$email, $name, $titleProduct];
            routeurMailing('refuseReservedPrice', $paramSeller);
        }
    } else {
        throw new Exception("ID de produit invalide pour refuser le prix réservé.");
    }
}