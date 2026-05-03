<?php


header('Content-Type: application/json');

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;
use App\Model\Repositories\AdminRepository;

if (!isset($_GET['id'])) {
    echo json_encode([]);
    exit;
}

$categoryId = (int) $_GET['id'];

$pdo = DatabaseConnection::getConnection();
$adminRepository = new AdminRepository($pdo);
$products = $adminRepository->getProductsByCategory($categoryId);
foreach ($products as &$p) {
    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $p['images'] = $userRepository->getImage($p['id_product']);
}
echo json_encode($products);

