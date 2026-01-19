<?php

require_once('src/model/comment.php');
require_once('src/lib/database.php');

function getComments()
{
    if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
        $id_product = $_GET['id_product'];
        $pdo = DatabaseConnection::getConnection();
        $commentRepostiory = new CommentRepository($pdo);
        $comments = $commentRepostiory->getCommentsFromProduct($id_product);

        header('Content-Type: application/json');
        echo json_encode($comments);
        exit();
    } else {
        throw new Exception("A problem occur during the reception of the comments !");
    }
}