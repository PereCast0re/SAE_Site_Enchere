<?php

// 1. En-têtes HTTP standard pour API REST
header('Content-Type: application/json; charset=utf-8');

// Correction de la portabilité des chemins (Slashes universels)
require_once __DIR__ . '/../model/pdo.php';

// 2. Clause de garde : Validation stricte du paramètre d'entrée
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'error' => "L'identifiant de la célébrité est manquant ou invalide."
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$celebrityId = (int) $_GET['id'];

try {
    // 3. Récupération des données
    // Conseil SAÉ : Optimise getProductsByCelebrity() avec un LEFT JOIN pour inclure les images en une seule requête SQL.
    $products = getProductsByCelebrity($celebrityId);

    if (empty($products)) {
        http_response_code(404); // Not Found
        echo json_encode([]);
        exit;
    }

    // 4. Hydratation et normalisation des données
    foreach ($products as &$product) {
        // Ajout des images
        $product['images'] = getImage($product['id_product']) ?? [];
        
        // Sécurisation de la présence de la clé celebrity
        if (empty($product['celebrity'])) {
            $product['celebrity'] = 'N/A';
        }
    }
    // Rupture impérative de la référence
    unset($product);

    // 5. Envoi de la réponse encodée proprement
    echo json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (\Exception $e) {
    // Masquage de l'erreur brute en production/évaluation pour des raisons de sécurité
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'Une erreur interne est survenue lors du traitement de la demande.'
    ]);
}