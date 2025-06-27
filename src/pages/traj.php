<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <title>GulfTraject - Prédiction trajet & type</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/traj.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/traj.js"></script>
</head>
<body>
  <?php
    include("src/globals/header.php");
  ?>
  <div id="container">
    <main>
      <h1 id="titre">Prédiction de la trajectoire et du type</h1>
      <div id="chooser">
        <choose>Choisissez un MMSI </choose>
        <div id="filter"></div>
      </div>
      <div id="trajMap"></div>

      <div id="type"></div>

    </main>
  </div>
</body>
</html>


