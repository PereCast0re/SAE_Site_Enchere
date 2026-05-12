<?php

namespace App\Model;

class Comment
{
    public int $id_product;
    public int $id_user;
    public string $comment;
    public string $comment_date;
    public string $full_name;
}