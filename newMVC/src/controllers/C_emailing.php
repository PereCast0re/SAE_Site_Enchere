<?php

require 'vendor/autoload.php';
use \Mailjet\Resources;

$apiKey = 'dd1eee2440b4bd6cf36a174f2dacf8c6';
$apisecret = '5ddabb00a7f6a8e75f50491865966284';

/// Router for emailing actions 
/// @param tableau de paramétres : param[0] = email destinataire, param[1] = nom utilisateur destinataire, le reste au besoin s
function routeurMailing($action, $param){
    switch($action){
        // liée fonctionnel
        case 'sendEmailConfirmationPlublish':
            sendEmailConfirmationPlublish($param);
            break;
        case 'InscriptionNewsletter':
            InscriptionNewsletter($param);
            break;
        // liée fonctionnel
        case 'InscriptionWebsite':
            InscriptionWebsite($param);
            break;
        // liée fonctionnel
        case  'EndAnnoncement':
            EndAnnoncement($param);
            break;
        // liée fonctionnel
        case  'EndAnnoncement2':
            EndAnnoncement2($param);
            break;
        // liée fonctionnel
        case 'Newsletter':
            SendNewsletter($param);
            break;
        // liée fonctionnel
        case 'sendEmailConfirmationUpdate':
            sendEmailConfirmationUpdate($param);
            break;
        case 'acceptReservedPrice':
            EmailReservedPriceAccepted($param);
            break;
        case 'acceptReservedBuyer':
            EmailReservedAcceptBuyer($param);
            break;
        case 'refuseReservedPrice':
            EmailReservedPriceDenied($param);
            break;
        // liée fonctionnel
        case 'winner':
            EmailWinner($param);
            break;
        // liée fonctionnel
        case 'productValidationAdmin':
            EmailProductValidationAdmin($param);
            break;
        // liée fonctionnel
        case 'validationProductUser':
            EmailValidationProductUser($param);
            break;
        // liée fonctionnel
        case 'refusalProductUser':
            EmailRefusalProductUser($param);
            break;
        // liée fonctionnel
        case 'acceptProductUser':
            EmailAcceptProductUser($param);
            break;
        // liée fonctionnel
        case 'sendEmailPendingPlublish':
            EmailPendingAdmin($param);
            break;
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

// Emailing functions : send a confirmation email when a annonce is updated
function sendEmailConfirmationUpdate($param){
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
                'Subject' => 'Modification de votre annonce sur BidStar',
                'TextPart' => 'Félicitations, votre annonce a été modifié avec succès !',
                'HTMLPart' => '<h3>Félicitations, votre annonce a été modifié avec succès !</h3><br />Merci de faire confiance à MaBonneEnchere pour vos achats et ventes en ligne.'
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
                'Subject' => 'Bienvenue sur BidStar !',
                'TextPart' => 'Merci de vous être inscrit sur BidStar !',
                'HTMLPart' => '<h3>Merci de vous être inscrit sur BidStar !</h3><br />Nous sommes ravis de vous compter parmi nos membres. Profitez de votre expérience d\'achat et de vente en ligne.'
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

// Emailing functions : send a confirmation email when a annonce ends (if sell)
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
                'Subject' => 'Votre annonce ' . $param[2] .' à trouvé preneur ',
                'TextPart' => 'Votre annonce à trouvé preneur !',
                'HTMLPart' => '<h3>Votre annonce '.$param[2].' est finis </h3><br />Votre produit à trouver un nouveau propriétaire.
                    <br>
                    Montant de la dernière enchère : '.$param[3].'
                    <br>
                    Contactez l\'acheteur pour finaliser la transaction.
                    <br>
                    Nom de l\'acheteur : '.$param[4].'<br>
                    email de l\'acheteur : '.$param[5]. '<br>
                    Vous conviendrait avec l\'acheteur des modalitès de paiements et de livraison comme expliqué sur notre site web dans la catégorie <a href="http://localhost/SAE_Site_Enchere/newMVC/index.php">Condition général de vente</a>.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// Emailing functions : send a confirmation email when a annonce ends (if not sell)
function EndAnnoncement2($param){
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
                'Subject' => 'Votre annonce ' . $param[2] .' n\'as pas trouvé preneur ',
                'TextPart' => 'Votre annonce n\'as pas trouvé preneur !',
                'HTMLPart' => '<h3>Votre annonce '.$param[2].' est finis </h3><br />Votre produit n\'as pas trouver un nouveau propriétaire.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

function EmailReservedPriceAccepted($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Prix réservé accepté pour votre annonce '.$param[2],
                'TextPart' => 'Vous avez accpeter la dernière offre.',
                'HTMLPart' => '<h3>Prix réservé accepté pour votre annonce '.$param[2].'</h3><br />Le prix réservé pour votre annonce a été accepté. 
                    <br>
                    Contactez l\'acheteur pour finaliser la transaction.
                    <br>
                    Nom de l\'acheteur : '.$param[3].'<br>
                    email de l\'acheteur : '.$param[4]. '<br>
                    Vous conviendrait avec l\'acheteur des modalitès de paiements et de livraison comme expliqué sur notre site web dans la catégorie <a href="http://localhost/SAE_Site_Enchere/newMVC/index.php">Condition général de vente</a>.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// acheteur au cas ou le prix de reserve n'est pas atteint
function EmailReservedAcceptBuyer($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Vous remporté l\'enchere malgré le prix de reserve non atteint '.$param[2],
                'TextPart' => 'Vous avez remporter l\'enchère.',
                'HTMLPart' => '<h3>Votre dernière offre pour l\'annonce '.$param[2].' à était accepter !</h3><br /> 
                    <br>
                    Vous serez contacter par le vendeur pour finaliser la transaction.
                    <br>
                    Vous conviendrait avec le vendeur des modalitès de paiements et de livraison comme expliqué sur notre site web dans la catégorie <a href="http://localhost/SAE_Site_Enchere/newMVC/index.php">Condition général de vente</a>.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// refus
function EmailReservedPriceDenied($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Prix réservé refuser pour votre annonce '.$param[2],
                'TextPart' => 'Vous avez refuser la dernière offre.',
                'HTMLPart' => '<h3>Prix de réserve refusez pour votre annonce '.$param[2].'</h3><br />Le prix réservé pour votre annonce a été refuser votre annonce et a présent hors ligne. 
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// acheteur au cas ou annonce finis et que c'est lui qui a la derniére enchére la plus haute
function EmailWinner($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Vous remporté l\'enchere '.$param[2],
                'TextPart' => 'Vous avez remporter l\'enchère.',
                'HTMLPart' => '<h3>Votre dernière offre pour l\'annonce '.$param[2].' était la bonne !</h3><br /> 
                    <br>
                    Vous serez contacter par le vendeur pour finaliser la transaction.
                    <br>
                    Vous conviendrait avec le vendeur des modalitès de paiements et de livraison comme expliqué sur notre site web dans la catégorie <a href="http://localhost/SAE_Site_Enchere/newMVC/index.php">Condition général de vente</a>.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// Admin pour notifier qu'une annonce est en attente de validation
function EmailProductValidationAdmin($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Validation d\'une annonce en attente',
                'TextPart' => 'Une annonce est en attente de validation.',
                'HTMLPart' => '<h3>Une annonce est en attente de validation</h3><br /> 
                    <br>
                    Veuillez vous connecter à votre compte administrateur pour valider ou refuser l\'annonce.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// User validation quand un admin valide son annonce en attente
function EmailValidationProductUser($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Validation de votre annonce ' .$param[2]. ' en attente',
                'TextPart' => 'Une annonce est en attente de validation.',
                'HTMLPart' => '<h3>Votre annonce ' .$param[2]. ' est en attente de validation</h3><br /> 
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// Cas ou annonce doit être verifie par un admin (refusé)
function EmailRefusalProductUser($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Refus de votre annonce ' .$param[2]. ' en attente',
                'TextPart' => 'Votre annonce a été refusée par un administrateur.',
                'HTMLPart' => '<h3>Votre annonce ' .$param[2]. ' a été refusée par un administrateur</h3><br /> 
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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


// Cas ou annonce doit être verifie par un admin (accepté)
function EmailAcceptProductUser($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Aprobation de votre annonce ' .$param[2]. ' !',
                'TextPart' => 'Votre annonce a été acceptée par un administrateur.',
                'HTMLPart' => '<h3>Votre annonce ' .$param[2]. ' a été acceptée par un administrateur</h3><br /> 
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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

// Email pour avertir que l'annonce est en attente de validation admin
function EmailPendingAdmin($param){
    global $apiKey, $apisecret;
    $mj = new \Mailjet\Client($apiKey, $apisecret,true,['version' => 'v3.1']);
    $body = [ 
        'Messages' => [
            [
                'From' =>[
                    'Email' => "barthoux44@gmail.com",
                    'Name' => "Admin BidStar"
                ],
                'To' => [
                    [
                        'Email' => $param[0],
                        'Name' => $param[1]
                    ]
                ],
                'Subject' => 'Annonce ' .$param[2].' en attente de validation admin',
                'TextPart' => 'Votre annonce ' .$param[2].' est en attente de validation par un administrateur.',
                'HTMLPart' => '<h3>Votre annonce ' .$param[2].' est en attente de validation par un administrateur</h3><br /> 
                    <br>
                    Nous vous informerons dès qu\'un administrateur aura examiné votre annonce.
                    <br>
                    Cordialement,<br>
                    L\'équipe BidStar.
                    '
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
