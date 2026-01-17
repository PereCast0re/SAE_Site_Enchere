<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require __DIR__ . '/../../vendor/autoload.php';

require 'config.php';

use Meilisearch\Client;

$q = $_GET['q'] ?? '';

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

try {
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $index = $client->index('products');

    $results = $index->search($q, ['limit' => 5]);

    $hits = $results->getHits();
    $output = array_map(function($h) {
        return [
            'id' => $h['id'],
            'titre' => $h['title']
        ];
    }, $hits);

    echo json_encode($output);

} catch (Exception $e) {
    echo json_encode([]);
}
