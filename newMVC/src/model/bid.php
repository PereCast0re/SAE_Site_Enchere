<?php

require_once('src/lib/database.php');

class BidRepository
{
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function bidProduct($id_product, $id_user, $newPrice, $currentPrice = null)
    {
        if ($currentPrice === null) {
            $currentPrice = getLastPrice($id_product)['last_price'];
        }
        $pdo = $this->connection;
        $request = "INSERT INTO Bid(id_product, id_user, current_price, new_price, bid_date) VALUES (:id_product, :id_user, :current_price, :new_price, NOW())";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([
            ':id_product' => $id_product,
            ':id_user' => $id_user,
            ':current_price' => $currentPrice,
            ':new_price' => $newPrice
        ]);

        return $success;
    }

    function getLastBidder($id_product)
    {
        $pdo = $this->connection;
        $request = "SELECT id_user FROM bid WHERE new_price IN (
    SELECT MAX(new_price) FROM bid WHERE id_product = ?
    );";
        $temp = $pdo->prepare($request);
        $temp->execute([$id_product]);

        return $temp->fetchColumn();
    }

    function getProductDate($id_product)
    {
        $pdo = $this->connection;
        $request = "SELECT end_date FROM Product WHERE id_product = ?";
        $temp = $pdo->prepare($request);
        $temp->execute([$id_product]);

        return $temp->fetchColumn();
    }

    function addTime($id_product)
    {
        $pdo = $this->connection;
        $request = "UPDATE Product SET end_date = DATE_ADD(end_date, INTERVAL 30 SECOND) WHERE id_product = ?";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([$id_product]);

        return $success;
    }
}