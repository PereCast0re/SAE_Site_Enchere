<?php

require_once('src/model/comment.php');
require_once('src/lib/database.php');

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