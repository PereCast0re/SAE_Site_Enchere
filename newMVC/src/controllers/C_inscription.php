<?php

require_once('src/model/pdo.php');

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
        $name = $input['name'];
        $firstname = $input['firstname'];
        $birth_date = $input['birth_date'];
        $address = $input['address'];
        $city = $input['city'];
        $postal_code = $input['postal_code'];
        $email = $input['email'];
        $password = $input['password'];
    } else {
        throw new Exception("Les données du formulaire sont invalides !");
    }

    // Appel de la fonction d'incription
    $success = createUser($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password);
    if (!$success) {
        throw new Exception("Impossible de s'inscrire pour le moment !");
    } else {
        // Redirection ou message de succès
        header('Location: index.php?action=user');
    }
}