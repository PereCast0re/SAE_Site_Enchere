<?php

require_once('src/lib/database.php');
require_once('src/model/product.php');

class CelebrityRepository
{
    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    
    function getCelebrityFromAnnoncement($id_product){
        $pdo = $this->connection;
        $requete = "SELECT name 
                    from celebrity as c
                    where c.id_celebrity = (
                        select id_celebrity 
                        from concerned as c 
                        where c.id_product  = :id
                        LIMIT 1);";
        try{
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ":id" => $id_product
            ]);
        }catch(PDOException $e){
            die("Error on get categorie from a annoncement : " .$e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function insertCelebrity($name, $statut){
        $pdo = $this->connection;
        $requete = "insert into celebrity (name, statut) VALUES (:name, :statut);";
        try{
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':name' => $name,
                ':statut' => $statut
            ]);
        } catch (PDOException $e){
            die("Error on setting catégorie from a annoncement :" .$e->getMessage());
        }
    }

    function linkCelebrityProduct($id_annoncement, $name){
        $pdo = $this->connection;
        $requete = "INSERT INTO concerned (id_product, id_celebrity) Values (:id_annoncement, (SELECT id_celebrity from celebrity where name like :name limit 1));";
        try{
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_annoncement' => $id_annoncement,
                ":name" => $name
            ]);
        } catch (PDOException $e){
            die("Error on linking your product and the celebrity :" .$e->getMessage());
        }
    }

    //Recherche autonome celebrity 
    function getCelebrityMod($writting){
        $pdo = $this->connection;
        $requete = "SELECT * from celebrity where name like :writting and statut = 1";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":writting" => $search = '%' . $writting . '%'
        ]);

        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function deleteCelebrity($id_product, $nameCelebrity){
        $pdo = $this->connection;

        try {
            $requete2 = "DELETE FROM celebrity where name = :nameCelebrity";
            $tmpCheck = $pdo->prepare($requete2);
            $tmpCheck->execute([
                ':nameCelebrity' => $nameCelebrity
            ]);

        } catch (PDOException $e) {
            $pdo->rollBack();
            die("Error deleting celebrity or link: " . $e->getMessage());
        }
    }
    
    function UpdateStatutCelebrity($id_product){
        $pdo = $this->connection;
        $requete = "UPDATE celebrity SET statut = 1 where id_celebrity = (SELECT id_celebrity from concerned where id_product = :id)";
        try{
            $tmp = $pdo->prepare($requete);
            $succes = $tmp->execute([':id' => $id_product]);
            return $succes;
        } catch (PDOException $e) {
            die("Error on updating your celebrity statut : " .$e->getMessage());
        }
    }

}