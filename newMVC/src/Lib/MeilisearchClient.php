<?php

namespace App\Lib;

use Meilisearch\Client;

class MeilisearchClient {
    private static ?Client $client = null;

    public static function getClient() {
        if (self::$client === null) {
            self::$client = new Client('http://127.0.0.1:7700', 'CLE_TEST_SAE_SITE');
        }
        return self::$client;
    }
}