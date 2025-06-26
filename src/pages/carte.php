<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <title>GulfTraject - Ajout d'un navire</title>

    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/carte.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/carte.js"></script>
</head>
<body>
  <?php
    include("src/globals/header.php");
  ?>
  <div id="container">
    <main>

      <div id="fullMap"></div>
    
      <div id="Alltable">
        <h1>Data base : boats on the golf of mexico</h1>
        <p>Click here if you want to add a boat</p>
        <a href="/addData">Ajout</a>
        <div id="allTable">
          <div id="pagination-controls">
            <button id="prevPage">Précédent</button>
            <span id="pageIndicator"></span>
            <button id="nextPage">Suivant</button>
          </div>
          <table id="table"></table>
        </div>
      </div>

      <div id="predPage">
        <a href="/cluster" target="_blank">Cluster des navires</a>
        <a href="/traj" target="_blank">Type et trajectoire des navires</a>
      </div>

    </main>
  </div>
</body>
</html>


