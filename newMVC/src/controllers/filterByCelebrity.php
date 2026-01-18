<?php
header('Content-Type: application/json');
require_once __DIR__ . '\..\model\pdo.php';

if (!isset($_GET['id'])) {
    echo json_encode([]);
    exit;
}

$id = (int)$_GET['id'];
$products = getProductsByCelebrity($id);
foreach ($products as &$p) {
    $p['images'] = getImage($p['id_product']);
    if (!isset($p['celebrity']) || empty($p['celebrity'])) {
        $p['celebrity'] = 'N/A';
    }
}
echo json_encode($products);