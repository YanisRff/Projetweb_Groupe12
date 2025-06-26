<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nautica - Accueil</title>
    <link rel="stylesheet" href="assets/css/accueil.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/accueil.js"></script>
</head>
<body>

  <?php
    include("src/globals/header.php");
  ?>

  <div id="middle ">
    <div class="zoom">
      <tit>Gulf Traject</tit>
      <sub_tit>look over the seas</sub_tit>
    </div>
  </div>

  <div>
  <who>Qui sommes nous?</who>
  <txt>Explorez avec nous chaque étape de la création web, du maquettage à l’interface dynamique, en passant par l’intégration HTML/CSS, la gestion des échanges asynchrones avec AJAX, et le traitement des données serveur en PHP — le tout appliqué à un jeu de données issu du domaine maritime.</txt>
  </div>

  

 
  
    
  <a href="/"><img  class="logo_bat" src="assets/images/logo_complet.png" alt="Logo Complet"></a>
  <a href="https://www.instagram.com/p/CeJtdqGs7q070ibq5hJH0uuae1BGvcnSQpVYjU0/?img_index=10"><img  class="logo_insta" src="assets/images/logo_insta.png" alt="Instagram"></a>

  <footer class="rectangle_bas" >
      <div id="tab_bas">
      <a class="bas_page">Ressources</a>
      <a class="bas_page">Explore</a>
      <a class="bas_page">Graphic Chart</a>
      <a class="bas_page">Our Database</a>
      <a class="bas_page"></a>  
      </div>
  </footer>
  
  
  <?php




    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>

</body>
</html>
