<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MeiliSearch\Client;
use GuzzleHttp\Client as GuzzleHttpClient;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;

// Crée un client Guzzle
$guzzle = new GuzzleHttpClient();
$adapter = new GuzzleAdapter($guzzle);

// Passe ce client explicitement à MeiliSearch
$client = new Client(
    'http://127.0.0.1:7700', // URL du serveur MeiliSearch
    null,                     // API key si nécessaire
    $adapter                  // client HTTP PSR-18
);

$indexes = $client->getIndexes();

echo "<pre>";
print_r($indexes);
echo "</pre>";
