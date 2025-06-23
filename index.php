<?php

$path = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';


switch ($path) {
    case '/':
        require 'src/pages/accueil.php';
        break;
    
    default:

        http_response_code(404);
        require 'src/pages/404.php';
        // echo "<a href='/'>Go back to home</a>";
        break;

}

