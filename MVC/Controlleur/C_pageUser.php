<?php
require_once("../Modele/pdo.php");

function get_all_annoncement($id_user){
    $tab_annoncements = get_Annonce_User($id_user);
    return $tab_annoncements;
}

