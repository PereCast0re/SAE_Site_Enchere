<?php
// Ce code et la pour vérifier l'état d'une annonce au niveau de sont temps 
// Executer dans le header pour garder une constance dans le temps
// Permet d'envoyer le mail de fin d'annonce 

if (!isset($_SESSION['user'])) {
    return;
}

$user = $_SESSION['user'];

require_once __DIR__ . '/../model/pdo.php';
require_once __DIR__ . '/../controllers/C_emailing.php';
require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../model/product.php';

//Définition du délais entre chaque vérification de fin d'annonce pour l'envoi de mail de 5 minutes
// La 300 c'est 5min en secondes
$delai = 120;
$date_now = time();
if (!isset($_SESSION['last_check'])) {
    $_SESSION['last_check'] = 0;
}

// Si la date actuelle - la date du dernier check et supérieur au délais autorisé 
if (($date_now - $_SESSION['last_check']) >= $delai) {
    $last_check = $date_now;
    if (!function_exists('verif')) {
        function verif($user)
        {
            $pdo = DatabaseConnection::getConnection();
            $productRepository = new ProductRepository($pdo);
            $annoncementClient = get_all_annoncement_notMailed();
            foreach ($annoncementClient as $annonce) {
                $date_fin = $annonce['end_date'];
                $current_date = date('Y-m-d H:i:s');
                $mail = $annonce['mailIsSent'];
                if ($current_date >= $date_fin && $mail != 1) {
                    $user_email = $user['email'];
                    $user_name = $user['name'];
                    $last_price = $productRepository->getLastPrice($annonce['id_product']);

                    if(!empty($last_price) && isset($last_price['last_price'])){                    
                        $buyer = $productRepository->getBuyer($annonce['id_product']);

                        $buyer_email = $buyer['email'];
                        $buyer_name = $buyer['name'] . ' ' . $buyer['firstname'];
                        $paramsBuyer = [$buyer_email, $buyer_name, $annonce['title'], $last_price['last_price']];
                        $params = [$user_email, $user_name, $annonce['title'], $last_price['new_price'], $buyer_name, $buyer_email];
                        routeurMailing('EndAnnoncement', $params);
                        routeurMailing('winner', $paramsBuyer);
                    }
                    else {
                        $params = [$user_email, $user_name, $annonce['title']];
                        routeurMailing('EndAnnoncement2', $params);
                    }
                    closeAnnoncement($annonce['id_product']);
                }
            }
        }
    }
    verif($user);
    $_SESSION['last_check'] = time();
}
