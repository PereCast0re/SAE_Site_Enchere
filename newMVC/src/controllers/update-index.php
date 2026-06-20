<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'config.php';
// CORRECTION : Inclusion obligatoire du fichier de connexion BDD
require_once __DIR__ . '/../lib/database.php'; 

use Meilisearch\Client;
use App\Lib\DatabaseConnection;
use Meilisearch\Exceptions\ApiException;

$client = new Client(MEILI_HOST, MEILI_KEY);

try {
    // 1. Initialisation des clients et configurations
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $indexName = 'search';

    // Création sécurisée de l'index
    try {
        $client->createIndex($indexName, ['primaryKey' => 'id']);
    } catch (ApiException $e) {
        if ($e->getErrorCode() !== 'index_already_exists') {
            throw $e;
        }
    }

    $index = $client->index($indexName);

    // 2. Optimisation : Configuration de l'index AVANT l'insertion des données
    $index->updateSettings([
        'searchableAttributes' => ['title', 'category_name', 'celebrity_name'],
        'filterableAttributes' => ['type', 'category_id', 'celebrity_id'],
        'displayedAttributes'  => ['id', 'type', 'title', 'product_id', 'category_id', 'celebrity_id', 'category_name', 'celebrity_name']
    ]);

    // 3. Connexion BDD
    $pdo = DatabaseConnection::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $batch = [];
    $batchSize = 500; // Taille optimale pour ménager la mémoire RAM et les requêtes HTTP

    // 4. Extraction et indexation des Produits (avec jointures)
    $sqlProducts = "
        SELECT 
            p.id_product, p.title,
            c.id_category, c.name AS category_name,
            ce.id_celebrity, ce.name AS celebrity_name
        FROM product p
        LEFT JOIN belongsto b ON b.id_product = p.id_product
        LEFT JOIN category c  ON c.id_category = b.id_category
        LEFT JOIN concerned co ON co.id_product = p.id_product
        LEFT JOIN celebrity ce ON ce.id_celebrity = co.id_celebrity
    ";

    $stmt = $pdo->query($sqlProducts);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $batch[] = [
            'id'             => 'product_' . $row['id_product'],
            'type'           => 'product',
            'title'          => str_replace('_', ' ', $row['title']),
            'product_id'     => (int)$row['id_product'],
            'category_id'    => $row['id_category'] ? (int)$row['id_category'] : null,
            'category_name'  => $row['category_name'] ?? 'N/A',
            'celebrity_id'   => $row['id_celebrity'] ? (int)$row['id_celebrity'] : null,
            'celebrity_name' => $row['celebrity_name'] ?? 'N/A'
        ];

        if (count($batch) >= $batchSize) {
            $index->addDocuments($batch);
            $batch = []; // Vidage du tampon mémoire
        }
    }

    // 5. Extraction et indexation des Catégories
    $stmt = $pdo->query("SELECT id_category, name FROM category");
    while ($c = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $batch[] = [
            'id'          => 'category_' . $c['id_category'],
            'type'        => 'category',
            'title'       => str_replace('_', ' ', $c['name']),
            'category_id' => (int)$c['id_category']
        ];

        if (count($batch) >= $batchSize) {
            $index->addDocuments($batch);
            $batch = [];
        }
    }

    // 6. Extraction et indexation des Célébrités
    $stmt = $pdo->query("SELECT id_celebrity, name FROM celebrity");
    while ($ce = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $batch[] = [
            'id'           => 'celebrity_' . $ce['id_celebrity'],
            'type'         => 'celebrity',
            'title'        => str_replace('_', ' ', $ce['name']),
            'celebrity_id' => (int)$ce['id_celebrity']
        ];

        if (count($batch) >= $batchSize) {
            $index->addDocuments($batch);
            $batch = [];
        }
    }

    // Envoi du reliquat de documents restants s'il y en a
    if (!empty($batch)) {
        $index->addDocuments($batch);
    }

    echo "Indexation globale exécutée et synchronisée par paquets avec succès.\n";

} catch (\Exception $e) {
    error_log("INDEXATION ERROR: " . $e->getMessage());
    echo "Une erreur critique est survenue lors de l'indexation : " . $e->getMessage() . "\n";
    exit(1);
}