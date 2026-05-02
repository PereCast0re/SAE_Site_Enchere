<?php

namespace App\Model;

class Product
{
    public int $id_product;
    public string $title;
    public string $description;
    public string $start_date;
    public string $end_date;
    public ?int $reserve_price = 0;
    public ?int $start_price = 0;
    public int $status;
    public ?int $mailIsSent = 0;
}