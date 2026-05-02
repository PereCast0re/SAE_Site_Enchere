<?php

namespace App\Model;

class User {
    public int $id_user;
    public string $name;
    public string $firstname;
    public string $birth_date;
    public string $address;
    public string $city;
    public string $postal_code;
    public string $email;
    private string $password;
    public int $Newsletter;
    private int $admin;
    public string $fullname;
}