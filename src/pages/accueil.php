<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> - Accueil</title>
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

  <footer>
  <a id="isen" href="https://isen-ouest.fr/"><img  class="logo_isen" src="assets/images/logo_isen_png.png" alt="Logo ISEN"></a>
    <div class="rectangle_bas_1">
      <a class="bas_page_tit">Ressources</a>
      <a class="bas_page_tit">Explore</a>
      <a class="bas_page_tit">References</a>
    </div>
    <div class="rectangle_bas_2">
      <a class="bas_page_sub" >Our Database</a>
      <a class="bas_page_sub" href="https://www.revenue.ie/en/online-services/support/software-developers/documents/ais/ais-codelists.pdf" target="_blank">AIS Documentation</a>
      <a class="bas_page_sub">Graphic Chart</a>
    </div>
    <div class="rectangle_bas_3">
      <a class="bas_page_sub">MCD</a>
      <a class="bas_page_sub" href="https://www.marinetraffic.com/fr/ais/home/centerx:-87.4/centery:25.2/zoom:6" target="_blank">Marine Traffic</a>
      <a class="bas_page_sub" href="https://coolors.co/1d3461-1f487e-cca43b-f4f2f3" target="_blank">For more colors</a>
    </div>

  </footer>
  
  <footer class="rectangle_bas_2
  
  <?php




    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>

</body>
</html>
