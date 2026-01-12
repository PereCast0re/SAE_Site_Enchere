<?php

require 'vendor/autoload.php';
use \Mailjet\Resources;

$apiKey = 'dd1eee2440b4bd6cf36a174f2dacf8c6';
$apisecret = '5ddabb00a7f6a8e75f50491865966284';

/// Router for emailing actions 
/// @param tableau de paramétres : param[0] = email destinataire, param[1] = nom utilisateur destinataire, le reste au besoin s
function routeurMailing($action, $param){
    switch($action){
        case 'sendEmailConfirmationPlublish':
            sendEmailConfirmationPlublish($param);
            break;
        case 'InscriptionNewsletter':
            InscriptionNewsletter($param);
            break;
        case 'InscriptionWebsite':
            InscriptionWebsite($param);
            break;
        case  'EndAnnoncement':
            EndAnnoncement($param);
            break;
        case 'Newsletter':
            SendNewsletter($param);
        default:
            echo("Action emailing non reconnue");
            break;
    }
}

// Emailing functions : send a confirmation email when a annonce is published
function sendEmailConfirmationPlublish($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);

    $body = [
        'Messages' => [
        [
            'From' =>[
                'Email' => "barthoux44@gmail.com",
                'Name' => "Admin MaBonneEnchere"
            ],
            'To' => [
                [
                    'Email' => $param[0],
                    'Name' => $param[1]
                ]
            ],
                'Subject' => 'Publication de votre annonce sur MaBonneEnchere',
                'TextPart' => 'Félicitations, votre annonce a été publiée avec succès !',
                'HTMLPart' => '<h3>Félicitations, votre annonce a été publiée avec succès !</h3><br />Merci de faire confiance à MaBonneEnchere pour vos achats et ventes en ligne.'
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);

    if ($response->success()) {
        echo("<script>console.log('Email envoyé avec succès');</script>");
    } else {
        echo("<script>console.log('Échec de l\'envoi de l\'email');</script>");
    }
}

// Emailing functions : send a confirmation email when a user subscribe to the newsletter
function InscriptionNewsletter($param){
    global $apiKey,  $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [
        'Messages' => [
        [
            'From' =>[
                'Email' => "barthoux44@gmail.com",
                'Name' => "Admin MaBonneEnchere"
            ],
            'To' => [
                [
                    'Email' => $param[0],
                    'Name' => $param[1]
                ]
            ],
                'Subject' => 'Inscription à la Newsletter MaBonneEnchere',
                'TextPart' => 'Bienvenue dans la communauté MaBonneEnchere !',
                'HTMLPart' => '<h3>Bienvenue dans la communauté MaBonneEnchere !</h3><br />Merci de vous être inscrit à notre newsletter. Restez à l\'écoute pour les dernières nouvelles et offres.'
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);

    if ($response->success()) {
        echo("feur success");
        echo("<script>console.log('Email envoyé avec succès');</script>");
    } else {
        echo("feur fail");
        echo("<script>console.log('Échec de l\'envoi de l\'email');</script>");
    }
}

// Emailing functions : send a confirmation email when a user create an account on the website
function InscriptionWebsite($param){
    global $apiKey,  $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [
        'Messages' => [
        [
            'From' =>[
                'Email' => "barthoux44@gmail.com",
                'Name' => "Admin MaBonneEnchere"
            ],
            'To' => [
                [
                    'Email' => $param[0],
                    'Name' => $param[1]
                ]
                ],
                'Subject' => 'Bienvenue sur MaBonneEnchere !',
                'TextPart' => 'Merci de vous être inscrit sur MaBonneEnchere !',
                'HTMLPart' => '<h3>Merci de vous être inscrit sur MaBonneEnchere !</h3><br />Nous sommes ravis de vous compter parmi nos membres. Profitez de votre expérience d\'achat et de vente en ligne.'
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);

    if ($response->success()) {
        echo("feur success");
        echo("<script>console.log('Email envoyé avec succès');</script>");
    } else {
        echo("feur fail");
        echo("<script>console.log('Échec de l\'envoi de l\'email');</script>");
    }
}

// Emailing functions : send a confirmation email when a annonce ends
function EndAnnoncement($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin MaBonneEnchere"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Votre annonce '.$param[2].' est terminée',
                'TextPart' => 'Votre annonce a pris fin. Connectez-vous pour voir les résultats.',
                'HTMLPart' => '<h3>Votre annonce '.$param[2].' est terminée</h3><br />Votre annonce a pris fin. Connectez-vous à votre compte MaBonneEnchere pour voir les résultats et les prochaines étapes.'
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);
    if ($response->success()) {
        echo("<script>console.log('Email envoyé avec succès');</script>");
    } else {
        echo("<script>console.log('Échec de l\'envoi de l\'email');</script>");
    }
}

function SendNewsletter($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin MaBonneEnchere"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Newsletter MaBonneEnchere',
                'TextPart' => 'Une nouvelle newsletter et a vous.',
                'HTMLPart' => '<h3>' .$param[2].'</h3><br /><p>' .$param[3].'</p>'
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);
    if ($response->success()) {
        echo("<script>console.log('Email envoyé avec succès');</script>");
    } else {
        echo("<script>console.log('Échec de l\'envoi de l\'email');</script>");
    }
}