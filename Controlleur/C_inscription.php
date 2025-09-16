<?php
require_once('../Modele/pdo.php');

// Vérifier que le formulaire a bien été soumis
if (
    isset($_POST['nom'], $_POST['prenom'], $_POST['naissance'], $_POST['adresse'],
        $_POST['ville'], $_POST['code_postal'], $_POST['email'], $_POST['mdp'])
) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $naissance = $_POST['naissance'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Appel de la fonction d'incription
    inscription($nom, $prenom, $naissance, $adresse, $ville, $code_postal, $email, $mdp, NULL);

    // Redirection ou message de succès
    header('Location: ../Vue/client.php');
    exit();
} else {
    echo "Données du formulaire manquantes.";
}