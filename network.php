<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Mon Réseau - ECE In</title>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>

</head>
<?php

require "verif_session.php";

?>
<body>

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
        <h1>Mon Réseau</h1>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRecherche">
            Rechercher un utilisateur
        </button>

        <br>

        <div class="modal fade" id="modalRecherche" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalScrollableTitle">Rechercher un utilisateur</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form class="row g-3" method="POST" action="network.php">
                            <div class="col-auto">
                                <input type="text" name="contenu_recherche" class="form-control" placeholder="Nom ou prénom...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="rechercher" class="btn btn-primary mb-3">Rechercher</button>
                            </div>
                        </form>

                        <br>

                        <div class="list-group">


                        <?php

                            include "liaison_bdd.php";

                            $sql = "SELECT * FROM utilisateur WHERE NOT identifiant_utilisateur =" . $_SESSION['identifiant_utilisateur'];
                            $result = mysqli_query($conn, $sql);


                            if (isset($_POST['rechercher'])) {

                                // On effectue la requête pour afficher tous les utilisateurs
                                $contenu_recherche = $_POST['contenu_recherche'];

                                // Si le champ est vide
                                if (empty($contenu_recherche)) {

                                    $sql = "SELECT * FROM utilisateur WHERE NOT identifiant_utilisateur =" . $_SESSION['identifiant_utilisateur'];
                                    $result = mysqli_query($conn, $sql);

                                } else {

                                    $sql = "SELECT * FROM utilisateur WHERE prenom =\"" . $contenu_recherche . "\" OR nom =\"" . $contenu_recherche . "\" AND NOT identifiant_utilisateur = " . $_SESSION['identifiant_utilisateur'];
                                    $result = mysqli_query($conn, $sql);
                                }

                            }

                            while ($data = mysqli_fetch_assoc($result)) {

                                echo "<a class=\"list-group-item list-group-item-action\">";

                                echo "<div class='container'>";

                                echo "<div class='row'>";

                                echo "<div class='col-md-4'>";

                                $photo = $data['photo'];

                                echo "<img src='$photo' class='rounded' width='170' height='150'>";

                                echo "</div>";

                                echo "<div class='col-md-8'>";

                                echo "<div class=\"d-flex w-100 justify-content-between\">";

                                echo "<h5 class='mb-1'>". $data['prenom'] . " " . $data['nom'] ."</h5>";

                                // On regarde si la personne est déjà amie avec l'utilisateur
                                $sql_ami = "SELECT * FROM ami WHERE ami.identifiant_utilisateur=" . $_SESSION['identifiant_utilisateur'] . " AND ami.identifiant_ami=" . $data['identifiant_utilisateur'];
                                $result_ami = mysqli_query($conn, $sql_ami);

                                $num_rows = mysqli_num_rows($result_ami);

                                if ($num_rows == 0) {

                                    echo "<form method='POST' action='ajout_ami.php'>";

                                    $id_ami = $data['identifiant_utilisateur'];

                                    echo "<input type='hidden' name='identifiant_ami' value=$id_ami>";

                                    echo "<small>  <button type=\"submit\" name='connecter' class=\"btn btn-success\">Se connecter</button> </small>";

                                    echo "</form>";

                                } else {

                                    echo "<form method='POST' action='retirer_ami.php'>";

                                    $id_ami = $data['identifiant_utilisateur'];

                                    echo "<input type='hidden' name='identifiant_ami' value=$id_ami>";

                                    echo "<small>  <button type=\"submit\" name='deconnecter' class=\"btn btn-danger\">Se déconnecter</button> </small>";

                                    echo "</form>";

                                }


                                echo "</div>";

                                echo "<p class=\"mb-1\">". $data['bio'] . "</p>";

                                echo "</div>";

                                echo "</div>";

                                echo "</div>";

                                echo "</a>";
                            }

                            if (isset($_POST['rechercher'])) {

                                echo "
                                    <script>
                                        $(document).ready(function(){
                                            $('#modalRecherche').modal('show');
                                        });
                                    </script>
                                ";
                            }

                        ?>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="list-group">

            <?php

            include "liaison_bdd.php";

            $id_utilisateur = $_SESSION['identifiant_utilisateur'];

            $sql = "SELECT * FROM ami,utilisateur WHERE ami.identifiant_utilisateur=$id_utilisateur AND ami.identifiant_ami = utilisateur.identifiant_utilisateur";

            $result = mysqli_query($conn, $sql);

            while ($data = mysqli_fetch_assoc($result)) {

                $fetched_id_utilisateur = $data['identifiant_utilisateur'];

                echo "<a href='wall_page.php?user=$fetched_id_utilisateur' class=\"list-group-item list-group-item-action\">";

                    echo "<div class='container'>";

                        echo "<div class='row'>";

                            echo "<div class='col-md-4'>";

                                $photo = $data['photo'];

                                echo "<img src='$photo' class='rounded' width='170' height='150'>";

                            echo "</div>";

                            echo "<div class='col-md-8'>";

                                echo "<div class=\"d-flex w-100 justify-content-between\">";

                                    echo "<h5 class='mb-1'>". $data['prenom'] . " " . $data['nom'] ."</h5>";

                                    echo "<form method='POST' action='retirer_ami.php'>";

                                    $id_ami = $data['identifiant_utilisateur'];

                                    echo "<input type='hidden' name='identifiant_ami' value=$id_ami>";


                                    echo "<small>  <button type=\"submit\" name='deconnecter' class=\"btn btn-danger\">Se déconnecter</button> </small>";

                                    echo "</form>";


                                echo "</div>";

                                echo "<p class=\"mb-1\">". $data['bio'] . "</p>";

                            echo "</div>";

                        echo "</div>";

                    echo "</div>";

                echo "</a>";
            }


            ?>


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
