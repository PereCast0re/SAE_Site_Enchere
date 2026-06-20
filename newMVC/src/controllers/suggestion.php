<?php

// 1. Configuration de la sécurité de l'affichage
// En production/évaluation, on journalise les erreurs au lieu de les afficher
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'config.php';

use Meilisearch\Client;

// 2. Clause de garde : Validation de la taille de la requête de recherche
$query = $_GET['q'] ?? '';

if (mb_strlen(trim($query)) < 2) {
    echo json_encode([]);
    exit;
}

try {
    // 3. Connexion et exécution de la recherche
    $client = new Client(MEILI_HOST, MEILI_KEY);
    
    // ATTENTION : Remplacement de 'products' par 'search' pour cohérence avec tes autres scripts
    $index = $client->index('search');

    // Recherche optimisée (limitée à 5 pour de l'autocomplétion rapide)
    $results = $index->search($query, ['limit' => 5]);
    $hits = $results->getHits();

    // 4. Structuration propre de la réponse (Mapping)
    $output = array_map(function($hit) {
        return [
            'id'    => $hit['id'] ?? null,
            'titre' => $hit['title'] ?? 'Sans titre'
        ];
    }, $hits);

    echo json_encode($output, JSON_UNESCAPED_UNICODE);

} catch (\Exception $e) {
    // Journalisation interne de la panne pour le débogage (sans la montrer à l'utilisateur)
    error_log("MEILISEARCH AUTOCOMPLETE ERROR: " . $e->getMessage());
    
    // Option pro : On peut renvoyer un code 500 ou un tableau vide selon la tolérance du Front-end
    http_response_code(500);
    echo json_encode([
        'error' => 'Le service de recherche est temporairement indisponible.'
    ]);
}