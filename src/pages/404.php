<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nautica - 404</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <!-- boostrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="assets/js/ajax.js"></script>
</head>
<body>
    <?php
    include("src/globals/header.php");
    ?>

    <div id="error-box">
        <p id="error-message"></p>
    </div>

    <main>

    <div id="error-page">
        <h2>Erreur 404</h2>
        <img class="image-404" src="assets/images/404.jpeg" alt="image error 404">

    </div>

    </main>

    <?php
    include("src/globals/footer.php");
    ?>

    
    
    <script src="assets/js/easter-egg.js"></script>
    
</body>
</html>
