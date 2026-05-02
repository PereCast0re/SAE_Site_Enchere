<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Lib\MeilisearchClient;

$client = MeilisearchClient::getClient();
$index = $client->index('search');

$results = $index->search('f');

echo '<pre>';
print_r($results->getHits());
