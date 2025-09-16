<?php
session_start();
require_once("../Modele/pdo.php");

if(!empty($_POST['email']) && !empty($_POST['mdp'])){
    if (isset($_POST['email'], $_POST['mdp'])){
        $email = $_POST['email'];
        $password = $_POST['mdp'];
        
        $info_client = authentification($email, $password);

        if ($info_client){
            $_SESSION['client'] = $info_client;
            header('Location: ../Vue/client.php');
            exit();
        }
        else{
            $_SESSION['error'] = "Mot de passe ou email faux";
            header('Location: ../Vue/connexion.php');
            exit();
        }
    }
}
else{
    $_SESSION['error'] = "Saisir un email et un mot de passe !";
    header('Location: ../Vue/connexion.php');
}