<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Messagerie - ECE In</title>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
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
            <?php
            echo "<li> <a href='wall_page.php?user=". $_SESSION['identifiant_utilisateur'] . "' class='nav-link px-2 link-dark'>Mon mur</a> </li>";
            ?>
            <li><a href="profile.php" class="nav-link px-2 link-dark">Profil</a></li>
            <li><a href="notifications.php" class="nav-link px-2 link-dark">Notifications</a></li>
            <li><a href="messaging.php" class="nav-link px-2 link-dark">Messagerie</a></li>
            <li><a href="jobs.php" class="nav-link px-2 link-dark">Emplois</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <a href="deconnexion.php">
                <button type="button" class="btn btn-outline-primary me-2">Deconnexion</button>
            </a>

        </div>
    </header>

    <!-- Main Content -->
    <div class="section">
        <h1>Messagerie</h1>
        <div class="card">
            <div class="card-header">
                Conversation avec Nom de la Personne
            </div>
            <div class="card-body">
                <div class="chat-box">
                    <!-- Afficher les messages ici -->
                    <p><strong>Nom de la Personne:</strong> Message reçu</p>
                    <p><strong>Vous:</strong> Message envoyé</p>
                    <!-- Répétez pour d'autres messages -->
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Écrire un message...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-3 mt-4 text-muted border-top">
        © 2024 ECE In
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>

