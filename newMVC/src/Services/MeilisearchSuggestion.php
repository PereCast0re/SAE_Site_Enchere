<?php

// 1. En-têtes HTTP et désactivation de l'affichage d'erreurs brutes en flux JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../controllers/config.php';

use Meilisearch\Client;
use Meilisearch\Exceptions\ApiException;
use App\Lib\MeilisearchClient;

/**
 * Endpoint API : Recherche globale via Meilisearch.
 * * Retourne les correspondances (produits, catégories, célébrités) au format JSON.
 */

$query = $_GET['q'] ?? '';

// Clause de garde : On commence la recherche à partir de 2 caractères pour optimiser les performances
if (mb_strlen(trim($query)) < 2) {
    echo json_encode([]);
    exit;
}

try {
    $client = MeilisearchClient::getClient();
    $index = $client->index('search');

    // 2. Exécution de la recherche avec récupération des attributs nécessaires au Front-end
    $results = $index->search($query, [
        'limit' => 10,
        // CORRECTION : Ajout de 'end_date', 'category_name', 'celebrity_name' et 'images' 
        // pour que ton JavaScript puisse hydrater correctement tes cartes HTML.
        'attributesToRetrieve' => [
            'id',
            'type',
            'title',
            'product_id',
            'category_id',
            'celebrity_id',
            'category_name',
            'celebrity_name',
            'end_date',
            'images'
        ]
    ]);

    // 3. Récupération des hits (méthode publique officielle du SDK)
    $hits = $results->getHits();

    // 4. Envoi de la réponse structurée
    echo json_encode($hits, JSON_UNESCAPED_UNICODE);

} catch (ApiException $e) {
    error_log("MEILISEARCH API ERROR: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la communication avec le moteur de recherche.']);
} catch (\Exception $e) {
    error_log("SEARCH CONTROLLER GLOBAL ERROR: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Une erreur système interne est survenue.']);
}