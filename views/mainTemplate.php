<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Contact</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg" id="mainNavbar">
    <div class="container-fluid container">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div> <img src ="assets/images/logo-YouInvest.png"></div>
            <div><a class="nav-link" href="index.php?action=dashboard">Tableau de bord</a></div>
            <div><a class="nav-link" href="index.php?action=newContactForm">Nouveau contact</a></div>
            <div><a class="nav-link" href="index.php?action=research">Recherche</a></div>
            <div><a href="index.php?action=logout" class='btn btn-secondary'>Déconnexion</a></div>
        </div>
    </div>
</nav>
<main>

    <?= $content ?>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>  
</body>
</html>