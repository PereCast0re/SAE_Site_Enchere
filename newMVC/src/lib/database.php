<?php
class DatabaseConnection
{
    private static ?PDO $pdo = null;
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO('mysql:host=localhost;dbname=auction_site;
                charset=utf8', 'root', '');
            /// Permet de lancer une exception si le pdo a une problème (requête SQL, connection, ...)
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            ///
        }
        return self::$pdo;
    }
}
