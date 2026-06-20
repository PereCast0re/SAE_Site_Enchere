<?php

require_once('src/lib/database.php');
require_once('src/model/comment.php');
require_once('src/model/favorite.php');
require_once("src/controllers/C_counterView.php");

/**
 * Contrôleur de la page de détail d'un produit.
 * Initialise et récupère toutes les données nécessaires (prix, commentaires, images, favoris)
 * avant de charger la vue.
 *
 * @param int|string $id_product Identifiant unique du produit.
 * @return void
 * @throws Exception Si le produit demandé n'existe pas en base de données.
 */
function Product($id_product): void
{
    // 1. Clause de garde : Validation du paramètre
    if (!isset($id_product) || $id_product < 0) {
        return;
    }

    $pdo = DatabaseConnection::getConnection();
    $productRepository = new ProductRepository($pdo);
    
    // 2. Récupération et validation du produit
    $p = $productRepository->getProduct($id_product);
    if ($p === false) {
        throw new Exception("This product doesn't exist !");
    }

    // Enregistrement de la vue
    AddNewView($p);

    // 3. Récupération des données associées
    $commentRepository = new CommentRepository($pdo);
    $comments = $commentRepository->getCommentsFromProduct($id_product);
    $category = $productRepository->getCategoryFromAnnoncement($id_product);

    // Gestion du prix courant (fallback sur le prix de départ si aucune enchère)
    $lastPriceInfo = $productRepository->getLastPrice($p['id_product']);
    $current_price = $lastPriceInfo['last_price'] ?? $p['start_price'];
    $reservePrice = (int)$p["reserve_price"];

    // 4. Traitement des médias (Correction du bug de filtrage croisé)
    // Note d'architecture : Idéalement, passer par $productRepository->getImages($id_product)
    $allMedias = getImage($id_product) ?? []; 

    $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Filtrage des images (et réindexation propre)
    $images = array_values(array_filter($allMedias, function ($img) use ($validExtensions) {
        $ext = strtolower(pathinfo($img['url_image'], PATHINFO_EXTENSION));
        return in_array($ext, $validExtensions);
    }));

    // Filtrage des certificats PDF depuis la source d'origine
    $certificate = array_values(array_filter($allMedias, function ($img) {
        return strtolower(pathinfo($img['url_image'], PATHINFO_EXTENSION)) === "pdf";
    }));

    // 5. Gestion des favoris / likes
    $favoriteRepository = new FavoriteRepository($pdo);
    $like = $favoriteRepository->getLikes($id_product)['nbLike'] ?? 0;
    
    // Vérification du statut favori de l'utilisateur connecté
    $isFav = false;
    if (isset($_SESSION['user']['id_user'])) {
        $isFav = $favoriteRepository->isProductFavorite($id_product, $_SESSION['user']['id_user']);
    }

    // 6. Calcul des 3 prochaines propositions d'enchères
    $price_ex = [];
    $tempPrice = $current_price;
    for ($i = 0; $i < 3; $i++) {
        $tempPrice += addToPrice($tempPrice);
        $price_ex[] = $tempPrice;
    }

    // 7. Rendu de la vue
    require("templates/product.php");
}

/**
 * Détermine le montant du pas d'enchère dynamique en fonction du prix actuel.
 *
 * @param float|int $currentPrice Le prix actuel du produit.
 * @return int Le montant à ajouter pour la prochaine enchère.
 */
function addToPrice($currentPrice): int
{
    if ($currentPrice < 100)   return 5;
    if ($currentPrice < 500)   return 10;
    if ($currentPrice < 1000)  return 20;
    if ($currentPrice < 5000)  return 50;
    if ($currentPrice < 10000) return 100;
    if ($currentPrice < 50000) return 500;
    
    return 1000;
}