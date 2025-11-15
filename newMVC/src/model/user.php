<?php

require_once('src/lib/database.php');

class UserRepository
{

    public DatabaseConnection $connection;

    // Encryptage via code cesar depuis une méthode faite avant insertion
    public function createUser($name, $firstname, $birth_date, $address, $city, $postal_code, $email, $password)
    {
        $requete = "INSERT INTO Users (name, firstname, birth_date, address, city, postal_code, email, password) VALUES (:name, :firstname, :birth_date, :address, :city, :postal_code, :email, :password)";
        try {
            $tmp = $this->connection->getConnection()->prepare($requete);
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

    // On part du principe de l'email et le password sont déja décripté
    public function authentication($email, $password)
    {
        $requete = "SELECT * from Users where email = :email and password = :password";
        try {
            $tmp = $this->connection->getConnection()->prepare($requete);
            $tmp->execute([
                ':email' => $email,
                ':password' => $password
            ]);
        } catch (PDOException $e) {
            die("Authentication error, try again ! /nError : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEmailUser($email, $id_user)
    {
        $requete = "UPDATE Users
                SET email = :email
                where id_user = :id_user";
        try {
            $tmp = $this->connection->getConnection()->prepare($requete);
            $tmp->execute([
                ":email" => $email,
                ":id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Modification error, try again !\nError : " . $e->getMessage());
        }
    }

    public function updatePasswordUser($id_user, $password)
    {
        $requete = "UPDATE Users
                SET password = :password
                Where id_user = :id_user";
        try {
            $tmp = $this->connection->getConnection()->prepare($requete);
            $tmp->execute([
                ":password" => $password,
                "id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Error during the modification of the password, try again !\nError : " . $e->getMessage());
        }
    }

    public function updateFullAddress($address, $city, $postal_code, $id_user)
    {
        $requete = "UPDATE Users
                set address = :address,
                    city = :city,
                    postal_code = :postal_code
                where id_user = :id_user";
        try {
            $tmp = $this->connection->getConnection()->prepare($requete);
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

    public function getAddress($id_user)
    {
        $requete = "SELECT address, postal_code, city
                from Users
                where id_user = :id_user
    ";
        try {
            $tmp = $this->connection->getConnection()->prepare($requete);
            $tmp->execute([
                ":id_user" => $id_user
            ]);
        } catch (PDOException $e) {
            die("Error when selecting the address, try again !\nError : " . $e->getMessage());
        }

        // auto_completion 
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }
}