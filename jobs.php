<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Emplois - ECE In</title>
</head>
<body>

<?php

require "verif_session.php";

?>
<div class="container">
    <!-- Header -->
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="images/logo.png" alt="ECE In Logo" class="img-fluid">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-2 link-secondary">Accueil</a></li>
            <li><a href="network.php" class="nav-link px-2 link-dark">Mon Réseau</a></li>
            <li><a href="profile.php" class="nav-link px-2 link-dark">Vous</a></li>
            <li><a href="notifications.php" class="nav-link px-2 link-dark">Notifications</a></li>
            <li><a href="messaging.php" class="nav-link px-2 link-dark">Messagerie</a></li>
            <li><a href="jobs.html" class="nav-link px-2 link-dark">Emplois</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <a href="deconnexion.php">
                <button type="button" class="btn btn-outline-primary me-2">Deconnexion</button>
            </a>

        </div>
    </header>

    <!-- Main Content -->
    <div class="section">
        <h1>Emplois</h1>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Titre de l'Emploi</h5>
                    <small>Entreprise</small>
                </div>
                <p class="mb-1">Description du poste.</p>
                <small>Date de publication</small>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Titre de l'Emploi</h5>
                    <small>Entreprise</small>
                </div>
                <p class="mb-1">Description du poste.</p>
                <small>Date de publication</small>
            </a>
            <!-- Répétez pour d'autres offres d'emploi -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-3 mt-4 text-muted border-top">
        © 2024 ECE In
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
