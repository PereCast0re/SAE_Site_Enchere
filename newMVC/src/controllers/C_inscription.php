<?php

require_once('src/lib/database.php');
require_once('src/model/user.php');
require_once('C_emailing.php');

function inscription(array $input)
{
    // Vérifier que le formulaire a bien été soumis
    if (
        isset(
        $input['name'],
        $input['firstname'],
        $input['birth_date'],
        $input['address'],
        $input['city'],
        $input['postal_code'],
        $input['email'],
        $input['password']
    )
    ) {
        $name = trim(htmlentities($input['name']));
        $firstname = trim(htmlentities($input['firstname']));
        $birth_date = trim(htmlentities($input['birth_date']));
        $address = trim(htmlentities($input['address']));
        $city = trim(htmlentities($input['city']));
        $postal_code = trim(htmlentities($input['postal_code']));
        $email = trim(htmlentities($input['email']));
        $password = trim(htmlentities(password_hash($input['password'], PASSWORD_ARGON2ID)));
    } else {
        throw new Exception("Les données du formulaire sont invalides !");
    }

    // Appel de la fonction d'incription
    $pdo = DatabaseConnection::getConnection();
    $userRepository = new UserRepository($pdo);
    $success = $userRepository->createUser($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password);
    if (!$success) {
        throw new Exception("Impossible de s'inscrire pour le moment !");
    } else {
        // Redirection ou message de succès
        routeurMailing('InscriptionWebsite', [$email, $name . ' ' . $firstname]);
        header('Location: index.php?action=user');
    }
}