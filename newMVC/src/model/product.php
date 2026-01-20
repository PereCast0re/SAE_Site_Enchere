<?php


require_once __DIR__ . '/../lib/database.php';
class ProductRepository
{

    private PDO $connection;

    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    function getCategory()
    {
        $pdo = $this->connection;
        $requete = "SELECT * FROM category";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute();
        } catch (PDOException $e) {
            die("Error retrieving categories, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }


    function getAllProduct()
    {
        $pdo = $this->connection;
        $requete = "SELECT * FROM Product";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute();
        } catch (PDOException $e) {
            die("Error retrieving products, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProduct($id_product)
    {
        $pdo = $this->connection;
        $requete = "SELECT * FROM Product WHERE id_product = ?";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([$id_product]);
        } catch (PDOException $e) {
            die("Error retrieving product, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function get_termined_annonces_by_client($id_client)
    {
        $pdo = $this->connection;
        $requete = "
        SELECT
            p.id_product,
            p.title AS titre,
            p.description,
            p.end_date,
            p.reserve_price,
            COALESCE(MAX(b.new_price), p.reserve_price) AS prix_en_cours
        FROM product p
        JOIN published pb ON pb.id_product = p.id_product
        LEFT JOIN bid b ON b.id_product = p.id_product
        WHERE pb.id_user = :id_client
        AND p.end_date < NOW()
        GROUP BY p.id_product, p.title, p.description, p.end_date, p.reserve_price
        ORDER BY p.end_date DESC
    ";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_client' => $id_client
            ]);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des annonces terminées pour le client : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_actual_annonces_by_client($id_client)
    {
        $pdo = $this->connection;
        $requete = "
        SELECT
            p.id_product,
            p.title AS titre,
            p.description,
            p.end_date,
            p.reserve_price,
            COALESCE(MAX(b.new_price), p.reserve_price) AS prix_en_cours
        FROM product p
        JOIN published pb ON pb.id_product = p.id_product
        LEFT JOIN bid b ON b.id_product = p.id_product
        WHERE pb.id_user = :id_client
        AND p.end_date >= NOW()
        GROUP BY p.id_product, p.title, p.description, p.end_date, p.reserve_price
        ORDER BY p.end_date ASC
    ";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_client' => $id_client
            ]);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des annonces en cours pour le client : " . $e->getMessage());
        }
        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function createProduct($title, $description, $start_date, $end_date, $reserve_price, $id_user, $status)
    {
        $pdo = $this->connection;
        $requete1 = "INSERT INTO Product (title, description, start_date, end_date, reserve_price, status)
                values (:title, :description, :start_date, :end_date, :reserve_price, :status);
    ";

        $requete2 = "INSERT INTO Published (id_product, id_user) values (:id_product, :id_user);";

        try {
            $temp = $pdo->prepare($requete1);
            $temp->execute([
                ":title" => $title,
                ":description" => $description,
                ":start_date" => $start_date,
                ":end_date" => $end_date,
                ":reserve_price" => $reserve_price,
                ":status" => $status,
            ]);

            $id_product = $pdo->lastInsertId();

            $temp = $pdo->prepare($requete2);
            $temp->execute([
                ":id_product" => $id_product,
                ":id_user" => $id_user
            ]);

            return $id_product;
        } catch (PDOException $e) {
            die("Error inserting your product into the database, try again !\n Error : " . $e->getMessage());
        }
    }

    function deleteProduct($id_product)
    {
        $pdo = $this->connection;
        $request = "DELETE FROM Product WHERE id_product = ?";
        $temp = $pdo->prepare($request);
        $success = $temp->execute([$id_product]);

        return $success;
    }

    function addImage($id_product, $path_image, $name_image)
    {
        $pdo = $this->connection;
        try {
            $requete2 = "INSERT INTO image (id_product, path_image, alt) VALUES (:id_product, :path_image, :name_image)";

            $temp = $pdo->prepare($requete2);
            $temp->execute([
                ":id_product" => $id_product,
                ":path_image" => $path_image,
                ":name_image" => $name_image
            ]);

            return true;

        } catch (PDOException $e) {
            die("Error inserting your image into the database, try again !\nError : " . $e->getMessage());
        }
    }

    function get_Annonce_User($id_client)
    {
        $pdo = $this->connection;
        $request = "SELECT * 
                from product as p 
                join published as pb on pb.id_product = p.id_product
                where pb.id_user = :id_client and p.end_date > date(now())
                ";
        try {
            $temp = $pdo->prepare($request);
            $temp->execute([
                "id_client" => $id_client
            ]);
        } catch (PDOException $e) {
            die("Error on extraction of your announcement" . $e->getMessage());
        }

        return $temp->fetchAll(PDO::FETCH_ASSOC);
    }

    function getLastPrice($id_product)
    {
        $pdo = $this->connection;
        $requete1 = "SELECT MAX(new_price) as last_price
                from bid
                where id_product = :id_product";
        try {
            $tmp = $pdo->prepare($requete1);
            $tmp->execute([
                ':id_product' => $id_product
            ]);
        } catch (PDOException $e) {
            die("Error retrieving the last price for the product, try again !\nError : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function getViewsWithOption($id_product, $option)
    {
        $pdo = $this->connection;
        switch ($option) {
            case 'M':
                $requete = "SELECT COUNT(view_number) as value, DATE_FORMAT(view_date, '%Y-%m') AS date FROM productview
                            WHERE id_product = :id
                            GROUP BY MONTH(view_date), YEAR(view_date)
                            ORDER BY view_date ASC;
                    ";
                $temp = $pdo->prepare($requete);
                $temp->execute([
                    ":id" => $id_product
                ]);
                return $temp->fetchall(PDO::FETCH_ASSOC);
            case 'Y':
                $requete = "SELECT COUNT(view_number) as value, YEAR(view_date) as date FROM productview
                            WHERE id_product = :id
                            GROUP BY YEAR(view_date)
                            ORDER BY view_date ASC;
                    ";
                $temp = $pdo->prepare($requete);
                $temp->execute([
                    ":id" => $id_product
                ]);
                return $temp->fetchall(PDO::FETCH_ASSOC);
            default:
                $requete = "SELECT COUNT(view_number) as value, DATE(view_date) as date FROM productview
                            WHERE id_product = :id
                            GROUP BY DATE(view_date), YEAR(view_date)
                            ORDER BY view_date ASC;
                    ";
                $temp = $pdo->prepare($requete);
                $temp->execute([
                    ":id" => $id_product
                ]);
                return $temp->fetchall(PDO::FETCH_ASSOC);
        }
    }

    function getPriceWithOption($id_product, $option)
    {
        $pdo = $this->connection;
        switch ($option) {
            case 'M':
                $requete = "SELECT MAX(new_price) as value, DATE(bid_date) as date FROM bid
                            WHERE id_product = :id 
                            AND MONTH(bid_date) = MONTH(NOW()) 
                            AND YEAR(bid_date) = YEAR(NOW())
                            GROUP BY DATE(bid_date)
                            ORDER BY bid_date ASC;
                    ";
                $temp = $pdo->prepare($requete);
                $temp->execute([
                    ":id" => $id_product
                ]);
                return $temp->fetchall(PDO::FETCH_ASSOC);
            case 'Y':
                $requete = "SELECT MAX(new_price) as value, DATE_FORMAT(bid_date, '%Y-%m') as date FROM bid
                            WHERE id_product = :id
                            GROUP BY MONTH(bid_date), YEAR(bid_date)
                            ORDER BY bid_date ASC;
                    ";
                $temp = $pdo->prepare($requete);
                $temp->execute([
                    ":id" => $id_product
                ]);
                return $temp->fetchall(PDO::FETCH_ASSOC);
            default:
                $requete = "SELECT new_price as value, DATE_FORMAT(bid_date, '%H:%i') as date FROM bid
                            WHERE id_product = :id
                            AND DAY(bid_date) = DAY(NOW()) 
                            AND MONTH(bid_date) = MONTH(NOW()) 
                            AND YEAR(bid_date) = YEAR(NOW())
                            ORDER BY bid_date ASC;
                    ";
                $temp = $pdo->prepare($requete);
                $temp->execute([
                    ":id" => $id_product
                ]);
                return $temp->fetchall(PDO::FETCH_ASSOC);
        }
    }

    /// used for admin
    function getCategoryFromAnnoncement($id_product)
    {
        $pdo = $this->connection;
        $requete = "SELECT name 
                    from category as c
                    where c.id_category = (
                        select id_category 
                        from belongsto as b 
                        where b.id_product = :id 
                        LIMIT 1);";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ":id" => $id_product,
            ]);
        } catch (PDOException $e) {
            die("Error on get categorie from a annoncement : " . $e->getMessage());
        }
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }


    // Recherche autonome categorie 
    function getCategoryMod($writting)
    {
        $pdo = connection();
        $requete = "SELECT * from category where name like :writting and statut = 1";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":writting" => $search = '%' . $writting . '%'
        ]);

        return $tmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function insertCategorie($name, $statut)
    {
        $pdo = $this->connection;
        $requete = "insert into category (name, statut) VALUES (:name, :statut);";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':name' => $name,
                ':statut' => $statut
            ]);
        } catch (PDOException $e) {
            die("Error on insert catégorie from your annoncement :" . $e->getMessage());
        }
    }

    function linkCategoryProduct($id_annoncement, $name)
    {
        $pdo = $this->connection;
        $requete = "INSERT INTO belongsto (id_product, id_category) Values (:id_annoncement, (SELECT id_category from category where name like :name Limit 1));";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_annoncement' => $id_annoncement,
                ":name" => $name
            ]);
        } catch (PDOException $e) {
            die("Error on linking your category to your annoncement :" . $e->getMessage());
        }
    }

    function UpdateStatut($id_product)
    {
        $pdo = $this->connection;
        $requete = "UPDATE product SET status = 1 where id_product = :id";
        try {
            $tmp = $pdo->prepare($requete);
            $succes = $tmp->execute([':id' => $id_product]);
            return $succes;
        } catch (PDOException $e) {
            die("Error on linking your categorie to your annonce : " . $e->getMessage());
        }
    }

    function UpdateStatutCategorie($id_product)
    {
        $pdo = $this->connection;
        $requete = "UPDATE category SET statut = 1 where id_category = (SELECT id_category from belongsto where id_product = :id)";
        try {
            $tmp = $pdo->prepare($requete);
            $succes = $tmp->execute([':id' => $id_product]);
            return $succes;
        } catch (PDOException $e) {
            die("Error on updating your category statut : " . $e->getMessage());
        }
    }

    function deleteCategory($id_product, $nameCategory)
    {
        $pdo = $this->connection;
        $requete2 = "DELETE from category where name = :nameC";

        try {
            $tmp2 = $pdo->prepare($requete2);
            $tmp2->execute([
                ':nameC' => $nameCategory
            ]);

        } catch (PDOException $e) {
            die("Error on deleting Category and his link to annoncement : " . $e->getMessage());
        }
    }

    function getCelebrityNameByAnnoncement($id_product)
    {
        $pdo = $this->connection;
        $requete = "SELECT c.name FROM celebrity c
                JOIN concerned con ON c.id_celebrity = con.id_celebrity
                WHERE con.id_product = :id_product";
        $tmp = $pdo->prepare($requete);
        $tmp->execute([
            ":id_product" => $id_product
        ]);
        // ne retourner que le nom en string
        return $tmp->fetch(PDO::FETCH_ASSOC);
    }

    function getThisProduct($id_product)
    {
        $pdo = $this->connection;
        $requete = "SELECT * FROM product where id_product = :id";

        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id' => $id_product
            ]);
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error on recuperation of this product : " . $e->getMessage());
        }
    }

    function getFilesFromAnnoncement($id_product)
    {
        $pdo = $this->connection;
        $requete = "SELECT * from image where id_product = :id";

        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id' => $id_product
            ]);
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error on recuperation of files from this product : " . $e->getMessage());
        }
    }

    function updateProduct($id, $title, $description, $start_date, $end_date, $reserve_price, $statut)
    {
        $pdo = $this->connection;
        $requete = "UPDATE Product 
                    SET title = :title, description = :description, start_date = :start_date, end_date = :end_date, reserve_price = :reserve_price, status = :status
                    WHERE id_product = :id;";

        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':title' => $title,
                ':description' => $description,
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':reserve_price' => $reserve_price,
                ':status' => $statut,
                ':id' => $id
            ]);

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            die("Error on updating your product into the database, try again !\n Error : " . $e->getMessage());
        }
    }

    function updateLinkCategoryProduct($id_annoncement, $name)
    {
        $pdo = $this->connection;
        $requete = "UPDATE belongsto 
                    SET id_category = (SELECT id_category from category where name like :name Limit 1)
                    WHERE id_product = :id_annoncement;";
        try {
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_annoncement' => $id_annoncement,
                ":name" => $name
            ]);
        } catch (PDOException $e) {
            die("Error on updating linking your category to your annoncement :" . $e->getMessage());
        }
    }

    function updateReservePrice($id){
        $pdo = $this->connection;
        $requete = "UPDATE product set reserve_price = null where id_product = :id";
        try{
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id' => $id
            ]);
            return $tmp;
        } catch (PDOException $e){
            die("Error on update your reserve price" .$e->getMessage());
        }
    }

    function getBuyer($id_product){
        $pdo = $this->connection;
        $requete = "SELECT u.name, u.firstname, u.email
                    from users as u
                    join bid as b on b.id_user = u.id_user
                    where b.id_product = :id_product
                    order by b.new_price desc
                    limit 1;";
        try{
            $tmp = $pdo->prepare($requete);
            $tmp->execute([
                ':id_product' => $id_product
            ]);
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            die("Error on get buyer info :" .$e->getMessage());
        }
    }

    function getAllProductLike($id){
        $pdo = $this->connection;
        $r = "SELECT * from interest where id_user = :id";
        try{
            $tmp = $pdo->prepare($r);
            $tmp->execute([
                ":id" => $id
            ]);
            return $tmp->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            die('Error on extraction of liked prduct : ' .$e->getMessage());
        }
    }
}
