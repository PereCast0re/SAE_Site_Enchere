<?php

use Symfony\Component\Validator\Constraints\Length;

require_once('src/model/comment.php');
require_once('src/lib/database.php');

function getComments()
{
    if (isset($_GET['id_product']) && $_GET['id_product'] >= 0) {
        $id_product = $_GET['id_product'];
        $pdo = DatabaseConnection::getConnection();
        $commentRepostiory = new CommentRepository($pdo);
        $comments = $commentRepostiory->getCommentsFromProduct($id_product);

        foreach ($comments as $comment) {
            $comment->full_name = strip_tags($comment->full_name);
            $comment->comment = nl2br(htmlspecialchars(strip_tags($comment->comment), ENT_NOQUOTES, 'UTF-8'));
            $comment->comment_date = strip_tags($comment->comment_date);
        }

        header('Content-Type: application/json');
        echo json_encode($comments);
        exit();
    } else {
        throw new Exception("A problem occur during the reception of the comments !");
    }
}