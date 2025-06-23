<?php

require_once 'Routeur/routeur.php';
require_once 'constants.php';
require_once 'database.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);
$pdo = dbConnect();

if (!$pdo) {
    echo "Error connecting to the database";
    exit();
}


$router = new Router();


// Exemple

$router->POST('/user-action', ["email", "password"], function($email, $password){
  global $pdo;
  login($pdo, $email, $password);
});
