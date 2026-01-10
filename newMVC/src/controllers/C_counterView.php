<?php
require_once("src/model/pdo.php");

function AddNewView($annoncement) {
    // bloque les bots (aidé car aucune connaissance sur ce sujet)
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    
    if (empty($user_agent) || strlen($user_agent) < 10 || 
        preg_match('/bot|crawl|spider|wget|curl/i', $user_agent)) {
        return false; // Bot détecté, on sort
    }
    
    // verification délais de 1 min par cookie
    $cookie_name = "viewed_" . $annoncement['id_product'];
    // si deja vue recemment 
    if (isset($_COOKIE[$cookie_name])) {
        return false; 
    }
    
    // verification délais de 1min par ip
    $last_view = getLastViewVerifBot($annoncement['id_product']);
    if ($last_view && (time() - strtotime($last_view['view_date']) < 60)) {
        return false;
    }
    
    // ajout de la vue
    $now = date('Y-m-d H:i:s');
    $tabview = getViewProduct($annoncement['id_product'], $now);
    
    if (empty($tabview)) {
        InsertNewView($annoncement['id_product'], $now);
    } else {
        UpdateNumberView($annoncement['id_product']);
    }
    
    // met dans les cookies pour 10 minutes
    setcookie($cookie_name, '1', time() + 600, '/');
    
    return true;
}
?>
