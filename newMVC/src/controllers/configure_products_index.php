<?php

require __DIR__ . '/../../vendor/autoload.php';
require 'config.php';

use Meilisearch\Client;

$client = new Client(MEILI_HOST, MEILI_KEY);
$index = $client->index('products');

$index->updateSearchableAttributes([
    'title',
    'description',
    'category_name'
]);

$index->updateFilterableAttributes([
    'category_id'
]);

echo "Index configuré";
