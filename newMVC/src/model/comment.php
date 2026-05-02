<?php

namespace App\Model;

use App\Lib\DatabaseConnection;

class Comment
{
    public int $id_product;
    public int $id_user;
    public string $comment;
    public string $comment_date;
    public string $full_name;
}