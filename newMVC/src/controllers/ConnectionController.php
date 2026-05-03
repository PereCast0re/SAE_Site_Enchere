<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\Repositories\UserRepository;
use DateTime;

class ConnectionController
{
    function userConnection(array $input)
    {
        if (!empty($input['email']) && !empty($input['password'])) {
            $email = $input['email'];
            $pdo = DatabaseConnection::getConnection();
            $userRepository = new UserRepository($pdo);
            $hasedpassword = $userRepository->gethashPassword($email);

            if ($hasedpassword && password_verify($input['password'], $hasedpassword)) {
                $info_user = $userRepository->authentication($email, $hasedpassword);
                var_dump($info_user);
                $info_user['DateConnexion'] = date("Y-m-d H:i:s");

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
        } else {
            $_SESSION['error'] = "Mot de passe ou email faux";
            header('Location: index.php?action=connection');
            exit();
        }
    }

    function UserCheckConnexion($DateConnexion)
    {
        $currentDate = date("Y-m-d H:i:s");
        $currentDate = new DateTime($currentDate);
        $DateConnexion = new DateTime($DateConnexion);
        $interval = $currentDate->diff($DateConnexion);

        $TotalHours = ($interval->days * 24) + $interval->h;

        // Check if the unterval is upper or lower than 12 hours
        if ($TotalHours >= 12) {
            $this->userDisconnection();
        }
    }

    function userDisconnection()
    {
        session_destroy();
        header('Location: index.php?action=connection');
        exit();
    }

    function disconnection()
    {
        session_start();
        session_destroy();
        header('location: index?action=connection');
    }

}