<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <title>GulfTraject - Ajout d'un navire</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/add.js"></script>
</head>
<body>
  <?php
    include("src/globals/header.php");
  ?>
  <div id="container">
    <main>
      <div id="form">
        <form onSubmit="sendData(event)" method="post">
                    <div class="tittle-3">
                        <p>Veuillez rentrer vos nouvelles données</p>
                    </div>
                    <div class="mb-3">
                        <label for="MMSI" class="create-div">MMSI </label>
                        <input type="number" min=0 class="form-control" id="MMSI" name="MMSI" required>
                    </div>
                    <div class="mb-3">
                        <label for="horodatage" class="create-div">Horodatage</label>
                        <input type="datetime-local" step=1 class="form-control" id="horodatage" name="Horodatage" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="create-div">Latitude</label>
                        <input type="number" min=0 step="any" class="form-control" id="latitude" name="Latitude" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="create-div">Longitude </label>
                        <input type="number" min=0 step="any" class="form-control" id="longitude" name="Longitude" required>
                    </div>
                    <div class="mb-3">
                        <label for="SOG" class="create-div">SOG </label>
                        <input type="number" min=0 step="0.1" class="form-control" id="SOG" name="SOG" required>
                    </div>
                    <div class="mb-3">
                        <label for="COG" class="create-div">COG </label>
                        <input type="number" min=0 step="0.1" class="form-control" id="COG" name="COG" required>
                    </div>
                    <div class="mb-3">
                        <label for="heading" class="create-div">Cap réel </label>
                        <input type="number" min=0 class="form-control" id="heading" name="Heading" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="create-div">Status </label>
                        <input type="text" pattern="^(O|1|2|3|5|8|15)$" class="form-control" id="status" name="Status" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="create-div">Nom du navire </label>
                        <input type="text" class="form-control" id="name" name="Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="length" class="create-div">Longueur </label>
                        <input type="number" min=0 step="any" class="form-control" id="length" name="Length" required>
                    </div>
                    <div class="mb-3">
                        <label for="width" class="create-div">Largeur </label>
                        <input type="number" min=0 step="any" class="form-control" id="width" name="Width" required>
                    </div>
                    <div class="mb-3">
                        <label for="draft" class="create-div">Tirant d'eau </label>
                        <input type="number" min=0 step="any" class="form-control" id="draft" name="Draft" required>
                    </div>
                    <div id="submitData">
                        <button class="btn btn-primary" type="submit" >Envoyer les données</button>
                    </div>
                    <div id="error" class="popup"></div>
                </form>
    </main>
  </div>
</body>
</html>

