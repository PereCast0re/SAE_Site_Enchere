<?php

require_once('src/model/pdo.php');

function userConnection(array $input)
{
    if (!empty($input['email']) && !empty($input['password'])) {
            $email = $input['email'];
            $password = $input['password'];

            $info_user = authentication($email, $password);

            if ($info_user) {
                $_SESSION['user'] = $info_user;
                header('Location: index.php?action=user');
                exit();
            } else {
                $_SESSION['error'] = "Mot de passe ou email faux";
                header('Location: index.php?action=connection');
                exit();
            }
    } else {
        $_SESSION['error'] = "Mot de passe ou email faux";
        header('Location: index.php?action=connection');
        exit();
    }
}

