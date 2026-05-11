<?php
// On empêche tout affichage parasite
ob_start(); 
ini_set('display_errors', 0);

header('Content-Type: application/json');

require __DIR__ . '/../../vendor/autoload.php';
require 'config.php'; 
require_once __DIR__ . '/../lib/database.php'; // Contient DatabaseConnection
require_once __DIR__ . '/../model/product.php';  // Contient ProductRepository et getImage

use Meilisearch\Client;

$q = $_GET['q'] ?? '';
$output = [];

try {
    // 1. Connexion unique à la BDD
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);

    // 2. Recherche Meilisearch
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $index = $client->index('search'); 
    $results = $index->search($q, ['limit' => 10]);
    $hits = $results->getHits();

    foreach ($hits as $h) {
        if ($h['type'] === 'product') {
            $pId = (int)$h['product_id'];

            // Récupération des datas via le repo déjà instancié
            $productData = $productRepository->getProduct($pId);
            $celebrity = $productRepository->getCelebrityNameByAnnoncement($pId);
            
            $output[] = [
                'id_product' => $pId,
                'type'       => $h['type'],
                'title'      => $h['title'],
                'end_date'   => $productData['end_date'] ?? null,
                'celebrity_name'  => $celebrity['name'] ?? 'N/A',
                'images'     => function_exists('getImage') ? getImage($pId) : []
            ];
        }
    }

    // On vide tout texte parasite qui aurait été généré avant
    ob_end_clean(); 
    echo json_encode($output);

} catch (Exception $e) {
    ob_end_clean();
    error_log("SEARCH ERROR: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}