<?php

require_once('src/lib/database.php');
require_once('src/model/user.php');

require_once('src/controllers/C_emailing.php');

function PostNewsletter(array $input){
    if(isset($input)){ 
        $title = $input['title_news'];
        $content = $input['content_mail_newsletter'];
        $pdo = DatabaseConnection::getConnection();
        $userRepo = new UserRepository($pdo);
        $lst_user = $userRepo->getUserNewsletter();
        foreach($lst_user as $u){
            sleep(1);
            $param = [$u['email'], $u['name'], $title, $content];
            routeurMailing('Newsletter', $param);
        }
        header('location: index.php?action=admin');
    }
    else{
        die("Error on recuperation of data from sending a new newsletter");
    }
}