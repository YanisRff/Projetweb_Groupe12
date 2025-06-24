<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <title>Nautica - Accueil</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/accueil.js"></script>
</head>
<body>
  <?php
    include("src/globals/header.php");
  ?>
  <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>

  <main>
    <table id="zone-test"></table>
  </main>
</body>
</html>
