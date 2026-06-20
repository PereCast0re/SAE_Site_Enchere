<?php

// 1. Définition des en-têtes HTTP pour une API REST
header('Content-Type: application/json; charset=utf-8');

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;
use App\Model\Repositories\AdminRepository;

// Correction du chemin pour compatibilité Windows/Linux (Utilisation du slash standard)
require_once __DIR__ . '/../model/pdo.php'; 

// 2. Clause de garde : Validation du paramètre d'entrée
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'error' => 'Identifiant de catégorie manquant ou invalide.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$categoryId = (int) $_GET['id'];

try {
    // 3. Récupération des produits
    // Note stratégique pour ta SAÉ : Pour avoir une note maximale, modifie ta fonction 
    // getProductsByCategory() pour qu'elle intègre directement les images via un LEFT JOIN.
    $pdo = DatabaseConnection::getConnection();
    $adminRepository = new AdminRepository($pdo);
    $products = $adminRepository->getProductsByCategory($categoryId);

    if (empty($products)) {
        http_response_code(404); // Not Found (Optionnel, tu peux aussi laisser un tableau vide avec un 200)
        echo json_encode([]);
        exit;
    }

    // 4. Hydratation des images (avec sécurisation de la référence)
    foreach ($products as &$product) {
        $pdo = DatabaseConnection::getConnection();
        $userRepository = new UserRepository($pdo);
        $product['images'] = $userRepository->getImage($product['id_product']) ?? [];
    }
    unset($product); // Rupture de la référence pour éviter les effets de bord systémiques

    // 5. Envoi de la réponse structurée
    echo json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (\Exception $e) {
    // En cas de panne BDD, on ne montre pas l'erreur brute (sécurité)
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'Une erreur interne est survenue lors de la récupération des données.'
    ]);
}