<?php
ini_set('display_errors', 0);
header('Content-Type: application/json');

require __DIR__ . '/../../vendor/autoload.php';
require 'config.php'; 
require_once __DIR__ . '/../model/pdo.php';
use App\Lib\DatabaseConnection;
use App\Model\Repositories\ProductRepository;
use App\Model\Repositories\UserRepository;

use Meilisearch\Client;

$q = $_GET['q'] ?? '';

if (strlen($q) < 0) {
    echo json_encode([]);
    exit;
}

try {
    $client = new Client(MEILI_HOST, MEILI_KEY);
    $index = $client->index('search'); 

    $results = $index->search($q, ['limit' => 10]);
    $hits = $results->getHits();

    $output = [];
    $pdo = DatabaseConnection::getConnection();

    foreach ($hits as $h) {
        if ($h['type'] === 'product') {
            $pId = (int)$h['product_id'];

            $pdo = DatabaseConnection::getConnection();
            $productRepository = new ProductRepository($pdo);
            $productData = $productRepository->getProduct($pId);
            $celebrity = $productRepository->getCelebrityNameByAnnoncement($pId);
            $userRepository = new UserRepository($pdo);
            
            $output[] = [
                'id_product' => $pId,
                'type'       => $h['type'],
                'title'      => $h['title'],
                'end_date'   => $productData['end_date'] ?? null,
                'celebrity_name'  => $celebrity['name'] ?? 'N/A',
                'images'     => $userRepository->getImage($pId) 
            ];
        }
    }

    echo json_encode($output);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([]);
}