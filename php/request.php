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

$router->GET('/test', [], function(){
  global $pdo;
  getTable($pdo);
});

$router->POST('/addData', ['mmsi', 'horodatage', 'latitude', 'longitude','sog','cog','heading','name','length','width','draft','status'], function($mmsi, $horodatage, $latitude, $longitude, $sog, $cog, $heading, $name, $length, $width, $draft, $status){
  global $pdo;
  saveData($pdo, $mmsi, $horodatage, $latitude, $longitude, $sog, $cog, $heading, $name, $length, $width, $draft, $status);
});

$router->GET('/carte', [], function(){
  global $pdo;
  getAll($pdo);
});

$router->GET('/cluster', [], function(){
  global $pdo;
  clusterAll($pdo);
});

$router->run();
