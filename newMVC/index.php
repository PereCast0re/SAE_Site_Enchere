<?php

session_start();

require_once('src/controllers/C_addProduct.php');
require_once('src/controllers/C_connection.php');
require_once('src/controllers/C_inscription.php');
require_once('src/controllers/C_pageProduct.php');
require_once('src/controllers/C_pageUser.php');
require_once('src/controllers/C_updateUser.php');

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'connection') {
            require("templates/connection.php");
        } elseif ($_GET['action'] === 'user') {
            require("templates/user.php");
        } elseif ($_GET['action'] === 'sell') {
            require_once("src/model/pdo.php");
            require("templates/sellProduct.php");
        } elseif ($_GET['action'] === 'userConnection') {
            userConnection($_POST);
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        require("templates/index.php");
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/preset/error.php');
}