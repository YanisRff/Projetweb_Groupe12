<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GulfTraject - Accueil</title>
    <link rel="stylesheet" href="assets/css/accueil.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/accueil.js"></script>
</head>
<body>

  <?php
    include("src/globals/header.php");
  ?>
  <main>
    <div class="middle">
      <tit2>Gulf Traject</tit2>
      <sub_tit>look over the seas</sub_tit>
    </div>
    
    <div id="weAre">
      <who>Qui sommes nous?</who>
      <txt>Explorez avec nous chaque étape de la création web, du maquettage à l’interface dynamique, en passant par l’intégration HTML/CSS, la gestion des échanges asynchrones avec AJAX, et le traitement des données serveur en PHP — le tout appliqué à un jeu de données issu du domaine maritime.</txt>
    </div>
  </main>

  <footer>
  <div id="footerIsen">
    <a id="isen" href="https://isen-ouest.fr/" target="_blank"><img  class="logo_isen" src="assets/images/logo_isen_png.png" alt="Logo ISEN"></img></a>
  </div>
  <div id="footerGit">
    <a class="git" href="https://github.com/YanisRff/Projet_BigData" target="blank"><img class="gitImg" src="assets/images/logo_git.png" alt="Logo Git">Big Data</a>
    <a class="git"  href="https://github.com/YanisRff/Projet_IA" target="blank"><img class="gitImg" src="assets/images/logo_git.png" alt="Logo Git">IA</a>
    <a class="git" href="https://github.com/YanisRff/Projetweb_Groupe12" target="blank"><img class="gitImg" src="assets/images/logo_git.png" alt="Logo Git">WEB</a>
  </div>
  <div id="footerInfo">
      <a class="bas_page_tit" id="Ressources">Ressources</a>
      <a class="bas_page_tit" id="Explore">Explore</a>
      <a class="bas_page_tit" id="Ref">References</a>
      <a class="bas_page_sub" id="DB" href="assets/py/data_clean.csv" download="DataBase_Gulf_Traject" >Our Database</a>
      <a class="bas_page_sub" id="AIS" href="https://www.revenue.ie/en/online-services/support/software-developers/documents/ais/ais-codelists.pdf" target="_blank">AIS Documentation</a>
      <a class="bas_page_sub" id="Graph" href="assets/rendu/CharteGraphique.pdf" download="CharteGraphique_Gulf_Traject" >Graphic Chart</a>
      <a class="bas_page_sub" id="MCD" href="assets/rendu/MCD.pdf" download="MCD_Gulf_Traject">MCD</a>
      <a class="bas_page_sub" id="Traf" href="https://www.marinetraffic.com/fr/ais/home/centerx:-87.4/centery:25.2/zoom:6" target="_blank">Marine Traffic</a>
      <a class="bas_page_sub" id="col" href="https://coolors.co/1d3461-1f487e-cca43b-f4f2f3" target="_blank">For more colors</a>
  </div>
  </footer>

  <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>

</body>
</html>
