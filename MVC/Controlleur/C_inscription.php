<?php
require_once('../Modele/pdo.php');

// Vérifier que le formulaire a bien été soumis
if (
    isset($_POST['name'], $_POST['firstname'], $_POST['birth_date'], $_POST['address'],
        $_POST['city'], $_POST['postal_code'], $_POST['email'], $_POST['password'])
) {
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $birth_date = $_POST['birth_date'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Appel de la fonction d'incription
    inscription($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password);

    // Redirection ou message de succès
    header('Location: ../Vue/user.php');
    exit();
} else {
    echo "Données du formulaire manquantes.";
}