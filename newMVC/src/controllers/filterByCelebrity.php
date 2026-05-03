<?php
header('Content-Type: application/json');

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;
use App\Model\Repositories\AdminRepository;

if (!isset($_GET['id'])) {
    echo json_encode([]);
    exit;
}

$id = (int)$_GET['id'];
$pdo = DatabaseConnection::getConnection();
$adminRepository = new AdminRepository($pdo);
$products = $adminRepository->getProductsByCelebrity($id);
foreach ($products as &$p) {
    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $p['images'] = $userRepository->getImage($p['id_product']);
    if (!isset($p['celebrity']) || empty($p['celebrity'])) {
        $p['celebrity'] = 'N/A';
    }
}
echo json_encode($products);