<?php

require __DIR__ . '/../../vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');

try {
    $index = $client->getIndex('products');
    echo "Index products déjà existant\n";
} catch (Exception $e) {
    $client->createIndex('products', ['primaryKey' => 'id']);
    echo "Index products créé\n";
    $index = $client->index('products');
}


$index->updateSearchableAttributes([
    'title',
    'description',
    'category_name'
]);

$index->updateFilterableAttributes([
    'category_id'
]);

$index->updateSortableAttributes([
    'price',
    'end_date'
]);

echo "Index products prêt\n";
