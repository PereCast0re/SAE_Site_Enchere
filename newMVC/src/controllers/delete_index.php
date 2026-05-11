

<?php
require __DIR__.'/../../vendor/autoload.php';
require 'config.php';

use Meilisearch\Client;

$client = new Client(MEILI_HOST, MEILI_KEY);

$client->deleteIndex('search');

