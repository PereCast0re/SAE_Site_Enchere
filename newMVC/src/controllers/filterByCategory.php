<?php
header('Content-Type: application/json');

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;

if (!isset($_GET['id'])) {
    echo json_encode([]);
    exit;
}

$categoryId = (int) $_GET['id'];

$products = getProductsByCategory($categoryId);
foreach ($products as &$p) {
    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $p['images'] = $userRepository->getImage($p['id_product']);
}
echo json_encode($products);

