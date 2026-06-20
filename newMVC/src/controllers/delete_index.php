<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'config.php';

use Meilisearch\Client;
use Meilisearch\Exceptions\ApiException;

/**
 * Script d'administration - Suppression de l'index Meilisearch.
 * * Ce script purge et supprime définitivement l'index spécifié.
 * À utiliser avec précaution.
 */

// Securité Flash : Empêcher l'exécution si le script est appelé via un navigateur 
// sans jeton de sécurité, ou privilégier l'exécution en ligne de commande (CLI).
if (php_sapi_name() !== 'cli' && (!isset($_GET['secret']) || $_GET['secret'] !== 'TON_TOKEN_DE_SECURITE')) {
    http_response_code(403);
    die("Accès refusé : Autorisation insuffisante pour effectuer cette action destructive.");
}

try {
    // 1. Initialisation du client Meilisearch
    $client = new Client(MEILI_HOST, MEILI_KEY);
    
    $indexName = 'search';

    // 2. Tentative de suppression de l'index
    $response = $client->deleteIndex($indexName);
    
    // 3. Confirmation du succès (Meilisearch retourne un tableau contenant le taskUid)
    echo "Succès : L'index '{$indexName}' a été programmé pour suppression (Task UID: " . $response['taskUid'] . ").\n";

} catch (ApiException $e) {
    // Gestion des erreurs spécifiques à l'API Meilisearch (ex: l'index n'existe déjà plus)
    echo "Erreur API Meilisearch : " . $e->getMessage() . " (Code: " . $e->getStatusCode() . ")\n";
} catch (\Exception $e) {
    // Gestion des erreurs globales (ex: problème de connexion réseau)
    echo "Erreur système générale : " . $e->getMessage() . "\n";
}