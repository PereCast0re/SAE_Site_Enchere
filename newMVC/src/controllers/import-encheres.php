<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'config.php';

use Meilisearch\Client;
use Meilisearch\Exceptions\ApiException;

/**
 * Script d'initialisation et de configuration de l'index Meilisearch.
 * * Crée l'index 'search' s'il n'existe pas.
 * * Configure les attributs de recherche, de filtrage et d'affichage.
 */

try {
    // 1. Connexion au client Meilisearch
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $indexName = 'search';
    
    echo "Connexion à Meilisearch réussie.\n";

    // 2. Création de l'index avec gestion propre de son existence
    try {
        $task = $client->createIndex($indexName, [
            'primaryKey' => 'id'
        ]);
        
        // Attendre que la création soit terminée avant de passer aux réglages
        $client->waitForTask($task['taskUid']);
        echo "Index '{$indexName}' créé avec succès.\n";
        
    } catch (ApiException $apiException) {
        // Si l'erreur est liée au fait que l'index existe déjà, on l'ignore et on continue
        if ($apiException->getErrorCode() === 'index_already_exists') {
            echo "L'index '{$indexName}' existe déjà. Passage à la mise à jour des paramètres.\n";
        } else {
            // Si c'est une autre erreur API (ex: mauvaise clé), on la propage
            throw $apiException;
        }
    }

    // 3. Sélection de l'index pour configuration
    $index = $client->index($indexName);

    // 4. Application et synchronisation des paramètres
    $settingsTask = $index->updateSettings([
        'searchableAttributes' => [
            'title', 
            'category_name', 
            'celebrity_name'
        ],
        'filterableAttributes' => [
            'type', 
            'category_id', 
            'celebrity_id'
        ],
        'displayedAttributes' => [
            'id', 
            'type', 
            'title', 
            'product_id', 
            'category_id', 
            'celebrity_id', 
            'category_name', 
            'celebrity_name'
        ]
    ]);

    // Forcer le script PHP à attendre que Meilisearch ait fini d'appliquer les filtres
    echo "Application des paramètres en cours...\n";
    $index->waitForTask($settingsTask['taskUid']);

    echo "Index '{$indexName}' configuré et prêt à l'emploi avec succès.\n";

} catch (ApiException $e) {
    echo "Erreur API Meilisearch : " . $e->getMessage() . " (Code Meili: " . $e->getErrorCode() . ")\n";
    exit(1);
} catch (\Exception $e) {
    echo "Erreur système générale : " . $e->getMessage() . "\n";
    exit(1);
}