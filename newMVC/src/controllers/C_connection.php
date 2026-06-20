<?php

require_once('src/lib/database.php');
require_once('src/model/user.php');

/**
 * Gère la tentative de connexion d'un utilisateur.
 *
 * @param array $input Les données de soumission (doit contenir 'email' et 'password').
 * @return void
 */
function userConnection(array $input): void
{
    // 1. Clause de garde : Vérification des champs requis
    if (empty($input['email']) || empty($input['password'])) {
        handleConnectionError();
    }

    $email = $input['email'];
    $password = $input['password'];

    // Note stratégique : Idéalement, le UserRepository devrait récupérer l'utilisateur 
    // uniquement par son email, et la vérification du hash se ferait ici.
    $hashedPassword = gethashPassword($email);

    // 2. Clause de garde : Vérification des identifiants
    if (!$hashedPassword || !password_verify($password, $hashedPassword)) {
        handleConnectionError();
    }

    // 3. Récupération des informations de l'utilisateur
    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $userInfo = $userRepository->authentication($email, $hashedPassword);

    // 4. Clause de garde : Échec de la récupération des données en BDD
    if (!$userInfo) {
        handleConnectionError();
    }

    // 5. Succès : Initialisation de la session et redirection
    $userInfo['DateConnexion'] = date("Y-m-d H:i:s");
    $_SESSION['user'] = $userInfo;
    
    header('Location: index.php?action=user');
    exit();
}

/**
 * Vérifie la validité temporelle de la session (Expiration après 12 heures).
 *
 * @param string $dateConnexion Date au format Y-m-d H:i:s
 * @return void
 */
function userCheckConnection(string $dateConnexion): void
{
    try {
        $currentDate = new DateTime();
        $connectionDate = new DateTime($dateConnexion);
        
        $interval = $currentDate->diff($connectionDate);
        $totalHours = ($interval->days * 24) + $interval->h;

        if ($totalHours >= 12) {
            userDisconnection();
        }
    } catch (Exception $e) {
        // En cas d'erreur de parsing de la date, on déconnecte par sécurité
        userDisconnection();
    }
}

/**
 * Déconnecte l'utilisateur en détruisant sa session et le redirige.
 *
 * @return void
 */
function userDisconnection(): void
{
    session_destroy();
    header('Location: index.php?action=connection');
    exit();
}

/**
 * Centralise la gestion des erreurs de connexion pour éviter la duplication de code.
 * (Principe DRY - Don't Repeat Yourself)
 *
 * @return void
 */
function handleConnectionError(): void
{
    $_SESSION['error'] = "Mot de passe ou email faux";
    header('Location: index.php?action=connection');
    exit();
}