<?php

require __DIR__.'/vendor/autoload.php';
require 'config.php';

use Meilisearch\Client;

$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');

$pdo = new PDO('mysql:host=localhost;dbname=auction_site', 'root', '');     

$statement = $pdo->query("SELECT id_product AS id, title, description, start_date, end_date, reserve_price, start_price, status FROM product");
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$index = $client->createIndex('products', ['primaryKey' => 'id']);

$index = $client->index('products');

$index->addDocuments($products);

echo "Importation terminée";