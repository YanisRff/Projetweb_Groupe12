<?php

$path = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';

if ($path !== '/' && str_ends_with($path, '/')) {
    $path = rtrim($path, '/');
}

error_log("PATH: " . $path);

switch ($path) {
    case '/':
        require 'src/pages/accueil.php';
        break;
    case '/addData':
        require 'src/pages/add.php';
        break;
    case '/carte':
        require 'src/pages/carte.php';
        break;
    case '/cluster':
        require 'src/pages/cluster.php';
        break;
    default:
        http_response_code(404);
        require 'src/pages/404.php';
        //echo "<a href='/'>Go back to home</a>";
        break;

}

