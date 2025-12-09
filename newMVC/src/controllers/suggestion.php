<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require __DIR__ . '/../../vendor/autoload.php';

require 'config.php';

use Meilisearch\Client;

// Récupération de la requête
$q = $_GET['q'] ?? '';

// Si la requête est trop courte, on renvoie directement un tableau vide
if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

try {
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $index = $client->index('products');

    // Recherche dans l'index
    $results = $index->search($q, ['limit' => 5]);

    // Utiliser getHits() pour récupérer le tableau des résultats
    $hits = $results->getHits();

    // Préparer la réponse JSON
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
