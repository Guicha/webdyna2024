<?php

require "verif_session.php";

include "liaison_bdd.php";

$mur_identifiant_utilisateur = $_GET['user'];

$sql = "SELECT * FROM utilisateur WHERE identifiant_utilisateur=$mur_identifiant_utilisateur";

$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

if ($num_rows != 0) {

    $data = mysqli_fetch_assoc($result);

    $mur_type = $data['type'];
    $mur_nom = $data['nom'];
    $mur_prenom = $data['prenom'];
    $mur_email = $data['email'];
    $mur_photo = $data['photo'];
    $mur_bio = $data['bio'];
    $mur_cv = $data['cv'];

} else {

    header('Location: index.php');
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Page personnelle - ECE In</title>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">

    </script>

</head>

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

        <div class="row">
            <div class="col">
                <h1>Informations générales</h1>
                <div class="card mb-3" style="max-width: 740px;">
                    <div class="row g-0">
                        <div class="col-md-4">

                            <?php
                            echo "<img src=$mur_photo class='rounded' width='170' height='150'>";
                            ?>

                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <?php
                                echo "<h4>" . $mur_prenom . " " .$mur_nom . "</h4>";
                                echo "<p class='card-text'>". $mur_bio ."</p>";
                                echo "<p class='card-text'> <small class='text-body-secondary'>". $mur_email ."</small> </p>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">

                <h1>Formation</h1>

            </div>
        </div>

        <div class="row">

            <h1>Amis</h1>

            <div class="list-group" style="max-height: 340px; overflow: auto">

                <?php

                include "liaison_bdd.php";

                $sql = "SELECT * FROM ami,utilisateur WHERE ami.identifiant_utilisateur=$mur_identifiant_utilisateur AND ami.identifiant_ami = utilisateur.identifiant_utilisateur";

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

                    // On regarde si la personne est déjà amie avec l'utilisateur
                    $sql_ami = "SELECT * FROM ami WHERE ami.identifiant_utilisateur=" . $_SESSION['identifiant_utilisateur'] . " AND ami.identifiant_ami=" . $data['identifiant_utilisateur'];
                    $result_ami = mysqli_query($conn, $sql_ami);

                    $num_rows = mysqli_num_rows($result_ami);

                    if ($data['identifiant_utilisateur'] == $_SESSION['identifiant_utilisateur']) {

                        echo "<small>  <button type=\"button\" class=\"btn btn-warning\" disabled>Vous</button> </small>";

                    } else {

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
                    }



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

        <br>


        <div class="row">

            <h1>Publications</h1>

        </div>


        <?php

        if ($_SESSION['identifiant_utilisateur'] == $mur_identifiant_utilisateur) {

            echo "
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalPublier'>
                Publier
            </button>  
            ";
        }

        ?>

        <br>

        <div class="modal fade" id="modalPublier" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">

                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalPublierTitre">Nouvelle Publication</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="nouvelle_publication.php" method="POST">

                            <div class="mb-3">
                                <label for="champ_auteur" class="form-label">Auteur</label>
                                <?php
                                    echo "<input id='champ_auteur' class='form-control' type='text' placeholder='". $_SESSION['prenom'] . " " . $_SESSION['nom'] ."' disabled>";
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="titre" placeholder="Titre de la publication">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Description brève de la publication"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="media" class="form-label">Media</label>
                                <input class="form-control form-control-sm" id="media" type="file">
                            </div>

                            <?php
                                $identifiant_utilisateur = $_SESSION['identifiant_utilisateur'];
                                $date = time();

                                echo "<input type='hidden' name='date' value=$date>";

                                echo "<input type='hidden' name='identifiant_auteur' value=$identifiant_utilisateur>";
                            ?>

                            <button type="submit" name="publier" class="btn btn-success">Publier</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </form>
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
