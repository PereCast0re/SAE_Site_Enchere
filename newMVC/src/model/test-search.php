<?php
require __DIR__ . '/../../vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');
$index = $client->index('search');

$results = $index->search('f');

echo '<pre>';
print_r($results->getHits());
