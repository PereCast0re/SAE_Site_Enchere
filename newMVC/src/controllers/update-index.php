<?php
require __DIR__ . '/../../vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');

try {
    $client->createIndex('search', ['primaryKey' => 'id']);
} catch (Exception $e) {
}
$index = $client->index('search');

$pdo = new PDO("mysql:host=localhost;dbname=auction_site;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$documents = [];

$sql = "
SELECT 
    p.id_product,
    p.title,
    c.id_category,
    c.name AS category_name,
    ce.id_celebrity,
    ce.name AS celebrity_name
FROM product p
LEFT JOIN belongsto b ON b.id_product = p.id_product
LEFT JOIN category c ON c.id_category = b.id_category
LEFT JOIN concerned co ON co.id_product = p.id_product
LEFT JOIN celebrity ce ON ce.id_celebrity = co.id_celebrity
";

foreach ($pdo->query($sql) as $row) {
    $cleanTitle = str_replace('_', ' ', $row['title']);
    $documents[] = [
        'id' => 'product_' . $row['id_product'],
        'type' => 'product',
        'title' => $cleanTitle,
        'product_id' => $row['id_product'],
        'category_id' => $row['id_category'],
        'category_name' => $row['category_name'],
        'celebrity_id' => $row['id_celebrity'],
        'celebrity_name' => $row['celebrity_name']
    ];
}

foreach ($pdo->query("SELECT id_category, name FROM category") as $c) {
    $documents[] = [
        'id' => 'category_' . $c['id_category'],
        'type' => 'category',
        'title' => str_replace('_', ' ', $c['name']),
        'category_id' => $c['id_category']
    ];
}

foreach ($pdo->query("SELECT id_celebrity, name FROM celebrity") as $ce) {
    $documents[] = [
        'id' => 'celebrity_' . $ce['id_celebrity'],
        'type' => 'celebrity',
        'title' => str_replace('_', ' ', $ce['name']),
        'celebrity_id' => $ce['id_celebrity']
    ];
}

$index->addDocuments($documents);

$index->updateSettings([
    'searchableAttributes' => ['title'],
    'filterableAttributes' => ['type','category_id','celebrity_id'],
    'displayedAttributes' => ['id','type','title','product_id','category_id','celebrity_id']
]);

echo "Index 'search' mis à jour avec succès. Total documents : " . count($documents);
