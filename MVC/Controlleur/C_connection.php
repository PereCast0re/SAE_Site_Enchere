<?php
session_start();
require_once("../Modele/pdo.php");

if(!empty($_POST['email']) && !empty($_POST['password'])){
    if (isset($_POST['email'], $_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $info_user = authentication($email, $password);

        if ($info_user){
            $_SESSION['user'] = $info_user;
            header('Location: ../Vue/user.php');
            exit();
        }
        else{
            $_SESSION['error'] = "Mot de passe ou email faux";
            header('Location: ../Vue/connection.php');
            exit();
        }
    }
}
else{
    $_SESSION['error'] = "Saisir un email et un mot de passe !";
    header('Location: ../Vue/connection.php');
}