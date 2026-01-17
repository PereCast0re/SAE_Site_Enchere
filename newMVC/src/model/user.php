<?php

require_once('src/lib/database.php');

class UserRepository
{

    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function createUser($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password)
    {
        $pdo = $this->connection;
        $requete = "INSERT INTO Users (name, firstname, birth_date, address, city, postal_code, email, password) VALUES (:name, :firstname, :birth_date, :address, :city, :postal_code, :email, :password)";
        try {
            $tmp = $pdo->prepare($requete);
            return $tmp->execute([
                ':name' => $name,
                ':firstname' => $firstname,
                ':birth_date' => $birth_date,
                ':address' => $address,
                ':city' => $city,
                ':postal_code' => $postal_code,
                ':email' => $email,
                ':password' => $password,
            ]);
        } catch (PDOException $e) {
            die("Inscription error, try again later !\nError : " . $e->getMessage());
        }
    }

    // On part du principe que l'email et le password sont déja décriptés
    function authentication($email, $password)
    {
        $pdo = $this->connection;
        $requete = "SELECT * from Users where email = :email and password = :password";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':email' => $email,
                ':password' => $password
            ]);
        } catch (PDOException $e) {
            die("Authentication error, try again ! /nError : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function updateEmailUser($email, $id_user)
    {
        $pdo = $this->connection;
        $requete = "UPDATE Users
                SET email = :email
                where id_user = :id_user";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ":email" => $email,
                ":id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Modification error, try again !\nError : " . $e->getMessage());
        }
    }

    function updatePasswordUser($id_user, $password)
    {
        $pdo = $this->connection;
        $requete = "UPDATE Users
                SET password = :password
                Where id_user = :id_user";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ":password" => $password,
                "id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Error during the modification of the password, try again !\nError : " . $e->getMessage());
        }
    }

    function updateFullAddress($address, $city, $postal_code, $id_user)
    {
        $pdo = $this->connection;
        $requete = "UPDATE Users
                set address = :address,
                    city = :city,
                    postal_code = :postal_code
                where id_user = :id_user";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ":address" => $address,
                ":city" => $city,
                ":postal_code" => $postal_code,
                ":id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Error during the modification of the adress, try again !\nError : " . $e->getMessage());
        }
    }

    function getAddress($id_user)
    {
        $pdo = $this->connection;
        $requete = "SELECT address, postal_code, city
                from Users
                where id_user = :id_user
    ";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ":id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Error when selecting the address, try again !\nError : " . $e->getMessage());
        }

        // auto_completion 
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function getUser($id_user)
    {
        $pdo = $this->connection;
        $request = "SELECT * FROM Users WHERE id_user = :id_user";
        $temp = $pdo->prepare($request);
        $temp->execute([
            "id_user" => $id_user
        ]);

        return $temp->fetch(PDO::FETCH_ASSOC);
    }

    function getRatingUser($id_user)
    {
        $pdo = $this->connection;
        $request = "SELECT AVG(rating) as score FROM Rating WHERE id_seller = :id_user";
        $temp = $pdo->prepare($request);
        $temp->execute([
            "id_user" => $id_user
        ]);

        return $temp->fetchColumn();
    }

    function getUserNewsletter(){
        $pdo = $this->connection;
        $requete = "SELECT name,email from users where newsletter = 1";
        $tmp = $pdo->prepare($requete);
        $tmp->execute();

        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }
}