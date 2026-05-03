<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\Repositories\CommentRepository;
use Exception;

class CommentController
{
    function addComment()
    {
        if (isset($_POST['id']) && $_POST['id'] >= 0 && isset($_POST['comment']) && strlen($_POST['comment']) > 0) {
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=connection");
                exit;
            }

            $id_product = $_POST['id'];
            $comment = $_POST['comment'];
            $id_user = $_SESSION['user']['id_user'];

            $pdo = DatabaseConnection::getConnection();
            $commentRepository = new CommentRepository($pdo);
            $commentRepository->addCommentToProduct($id_product, $id_user, $comment);
            header("Location: index.php?action=product&id=" . $id_product);
            exit;
        } else {
            throw new Exception("Échoue sur l'ajout du commentaire");
        }
    }

    function getComments()
    {
        if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
            $id_product = $_GET['id_product'];
            $pdo = DatabaseConnection::getConnection();
            $commentRepostiory = new CommentRepository($pdo);
            $comments = $commentRepostiory->getCommentsFromProduct($id_product);

            foreach ($comments as $comment) {
                $comment->full_name = strip_tags($comment->full_name);
                $comment->comment = nl2br(htmlspecialchars(strip_tags($comment->comment)));
                $comment->comment_date = strip_tags($comment->comment_date);
            }

            header('Content-Type: application/json');
            echo json_encode($comments);
            exit();
        } else {
            throw new Exception("A problem occur during the reception of the comments !");
        }
    }
}