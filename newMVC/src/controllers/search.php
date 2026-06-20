<?php

// 1. Initialisation stricte de la mise en mémoire tampon
ob_start(); 
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../../vendor/autoload.php';
require 'config.php'; 
require_once __DIR__ . '/../model/pdo.php';
use App\Lib\DatabaseConnection;
use App\Model\Repositories\ProductRepository;
use App\Model\Repositories\UserRepository;
use Meilisearch\Client;

$query = $_GET['q'] ?? '';
$output = [];

try {
    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);

    // 2. Initialisation et exécution de la recherche
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $index = $client->index('search'); 
    
    $results = $index->search($query, ['limit' => 10]);
    $hits = $results->getHits();

    // 3. Traitement et hydratation des résultats
    foreach ($hits as $hit) {
        if (($hit['type'] ?? '') === 'product') {
            $productId = (int)$hit['product_id'];

            // Note de performance : Idéalement, stocke 'end_date', 'celebrity_name' et 'images' 
            // directement dans Meilisearch pour supprimer ces 3 appels SQL par itération.
            $productData = $productRepository->getProduct($productId);
            $celebrity = $productRepository->getCelebrityNameByAnnoncement($productId);
            // $userRepository = new UserRepository($pdo);
            $images = getImage($productId) ?? [];
            
            $output[] = [
                'id_product'     => $productId,
                'type'           => $hit['type'],
                'title'          => $hit['title'],
                'end_date'       => $productData['end_date'] ?? null,
                'celebrity_name' => $celebrity['name'] ?? 'N/A',
                'images'         => $images
            ];
        }
    }

    // 4. Nettoyage sécurisé du tampon et envoi du JSON
    if (ob_get_length()) {
        ob_end_clean(); // Supprime tout warning ou echo parasite survenu pendant le script
    }
    
    echo json_encode($output, JSON_UNESCAPED_UNICODE);

} catch (\Exception $e) {
    // En cas d'erreur, on nettoie le tampon pour ne pas corrompre le JSON de secours
    if (ob_get_length()) {
        ob_end_clean();
    }
    
    error_log("SEARCH ERROR: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'error' => 'Une erreur est survenue lors de la recherche.'
    ]);
}