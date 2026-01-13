<?php

require __DIR__ . '/../../vendor/autoload.php';

use Meilisearch\Client;

/* -------------------------
   Connexions
-------------------------- */

$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');

$pdo = new PDO(
    'mysql:host=localhost;dbname=auction_site;charset=utf8',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

/* -------------------------
   Requête SQL
-------------------------- */

$sql = "
SELECT 
    p.id_product AS id,
    p.title,
    p.description,
    p.start_price,
    p.end_date,
    GROUP_CONCAT(c.name) AS categories
FROM product p
LEFT JOIN belongsto b ON b.id_product = p.id_product
LEFT JOIN category c ON c.id_category = b.id_category
GROUP BY p.id_product
";

$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* -------------------------
   Normalisation données
-------------------------- */

foreach ($products as &$product) {
    $product['categories'] = $product['categories']
        ? explode(',', $product['categories'])
        : [];
}

/* -------------------------
   Index Meilisearch
-------------------------- */

$index = $client->index('products');
$index->addDocuments($products);

echo "Index products mis à jour : " . count($products) . " produits\n";
