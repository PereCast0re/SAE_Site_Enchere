<?php
header('Content-Type: application/json');

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;

if (!isset($_GET['id'])) {
    echo json_encode([]);
    exit;
}

$id = (int)$_GET['id'];
$products = getProductsByCelebrity($id);
foreach ($products as &$p) {
    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $p['images'] = $userRepository->getImage($p['id_product']);
    if (!isset($p['celebrity']) || empty($p['celebrity'])) {
        $p['celebrity'] = 'N/A';
    }
}
echo json_encode($products);