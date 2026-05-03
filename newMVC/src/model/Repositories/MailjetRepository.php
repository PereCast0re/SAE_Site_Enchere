<?php

namespace App\Model\Repositories;

use PDO;
use PDOException;

class MailjetRepository
{
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    ///////////////////////////////////////////// Cloture d'une annonce ////////////////////////////////////////////////////////
    /// Si mailIsSent = 1 alors l'email et deja evoyé et permet de bloqué les envois multiples
    public function closeAnnoncement(int $id_product)
    {
        $pdo = $this->connection;
        $requete = "UPDATE product SET end_date = now(), mailIsSent = 1 WHERE id_product = :id_product";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_product" => $id_product
        ]);
    }

    public function get_all_annoncement_notMailed()
    {
        $pdo = $this->connection;
        $requete = 'SELECT * from product where mailIsSent != 1';
        $tmp = $pdo->prepare($requete);
        $tmp->execute();
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function subscribeNewsletter($email)
    {
        $pdo = $this->connection;
        try {
            $requete = "UPDATE users SET newsletter = 1 WHERE email = :email";
            $temp = $pdo->prepare($requete);
            $temp->execute([
                ":email" => $email
            ]);
        } catch (PDOException $e) {
            die("Error subscribing to the newsletter, try again !\nError : " . $e->getMessage());
        }
    }
}