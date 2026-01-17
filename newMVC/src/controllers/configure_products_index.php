<?php

require __DIR__ . '/../../vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');
$index = $client->index('products');

/* Champs recherchables */
$index->updateSearchableAttributes([
    'title',
    'description',
    'category_name'
]);

/* Champs filtrables (optionnel mais propre) */
$index->updateFilterableAttributes([
    'category_id'
]);

echo "Index configuré";
