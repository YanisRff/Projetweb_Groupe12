<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nautica - Accueil</title>
    <link rel="stylesheet" href="assets/css/accueil.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/accueil.js"></script>
</head>
<body>
  <header class="rectangle_haut">
    <div id="linkTo">
      <a class="haut_page" href="/">Accueil</a>
      <a class ="haut_page"href="/addData">Ajout</a>
      <a class="haut_page" href="/carte">Carte</a>
      <haut_page></haut_page>
    </div>
  </header>
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

  <div class="rectangle_bas"></div>
  <div class="ligne"></div>

  <?php




    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>

</body>
</html>
