<?php
// Ce code et la pour vérifier l'état d'un annonce au niveau de sont temps 
// Executer dans le header pour garder une constance dans le temps
// Permet d'envoyer le mail de fin d'annonce 

session_start();
$user = $_SESSION['user'];

require_once __DIR__. '/../model/pdo.php';
require_once __DIR__. '/../controllers/C_emailing.php';

//Définition du délais entre chaque vérification de fin d'annonce pour l'envoi de mail de 5 minutes
// La 300 c'est 5min en secondes
$delai =  300;
$date_now = time();
if (!isset($_SESSION['last_check'])){
    $_SESSION['last_check'] = 0;
}

// Si la date actuelle - la date du dernier check et supérieur au délais autorisé 
if (($date_now - $_SESSION['last_check']) >= $delai) {    $last_check = $date_now;
    verif($user);
    $_SESSION['last_check'] = time();
}

function verif($user){
    $annoncementClient = get_all_annoncement_notMailed();
    foreach($annoncementClient as $annonce){
        $date_fin = $annonce['date_fin'];
        $current_date = date('Y-m-d H:i:s');
        $mail = $annonce['mailIsSent'];
        if($current_date >= $date_fin && $mail != 1){
            // L'annonce est terminée, envoyer le mail de fin d'annonce
            $user_email = $user['email'];
            $user_name = $user['name'];
            $params = [$user_email, $user_name, $annonce['titre']];
            routeurMailing('EndAnnoncement', $params);
            closeAnnoncement($annonce['id_annonce']);
        }
    }
}