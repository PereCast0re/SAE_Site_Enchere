

<?php
require __DIR__.'/../../vendor/autoload.php';
require 'config.php';

use Meilisearch\Client;

$client = new Client(MEILI_HOST, "CLE_TEST_SAE_SITE");

$client->deleteIndex('search');

