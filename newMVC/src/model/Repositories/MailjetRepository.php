<?php

namespace App\Model\Repositories;

use PDO;

class MailjetRepository {
    ///////////////////////////////////////////// Cloture d'une annonce ////////////////////////////////////////////////////////
    /// Si mailIsSent = 1 alors l'email et deja evoyé et permet de bloqué les envois multiples
    public static function closeAnnoncement(int $id_product)
    {
        $pdo = connection();
        $requete = "UPDATE product SET end_date = now(), mailIsSent = 1 WHERE id_product = :id_product";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_product" => $id_product
        ]);
    }

    public static function get_all_annoncement_notMailed()
    {
        $pdo = connection();
        $requete = 'SELECT * from product where mailIsSent != 1';
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }
}