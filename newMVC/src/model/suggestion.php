<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../controllers/config.php';

use Meilisearch\Client;

$q = $_GET['q'] ?? '';
if (strlen($q) < 1) {
    echo json_encode([]);
    exit;
}

$client = new Client(MEILI_HOST, MEILI_KEY);
$index = $client->index('search');

// Recherche
$results = $index->search($q, [
    'limit' => 10,
    'attributesToRetrieve' => ['id','type','title','product_id','category_id','celebrity_id']
]);

$hits = $results->getHits(); // <-- méthode publique

echo json_encode($hits);
