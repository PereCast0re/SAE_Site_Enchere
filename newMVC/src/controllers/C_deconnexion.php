<?php

/**
 * Déconnecte proprement l'utilisateur.
 * * Libère toutes les variables de session, détruit la session côté serveur,
 * efface le cookie de session sur le navigateur et redirige vers la page de connexion.
 *
 * @return void
 */
function userDisconnection(): void
{
    // 1. S'assurer que la session est démarrée avant de tenter de la détruire
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Vider le tableau des variables de session en mémoire
    $_SESSION = [];

    // 3. Détruire le cookie de session sur le navigateur de l'utilisateur
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000, // Date d'expiration dans le passé pour forcer la suppression
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // 4. Détruire le fichier de session sur le serveur
    session_destroy();

    // 5. Redirection sécurisée
    header('Location: index.php?action=connection');
    exit();
}