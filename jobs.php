<?php

require "verif_session.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Emplois - ECE In</title>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>

    <style>
        /* Style pour fixer les boutons de la card */
        .card {
            position: relative;
        }
        .btn-fixed-droite {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        .btn-fixed-gauche {
            position: absolute;
            bottom: 10px;
            left: 10px;
        }
    </style>

</head>
<body>

<script>
    function Gestion_bouton_supp_et_contacter(Id_entreprise,Id_emploi) {
        $.ajax({
            url: 'gestion_bouton_emplois.php',
            type: 'GET',
            data: { 'envoi_information': 1, 'id_entreprise':Id_entreprise },
            success: function(valeur) {
                var contenu = '';
                if(valeur == 0) {
                    contenu = '<button type="button" class="btn btn-success btn-fixed-gauche Contacter_entreprise" data-id="' + Id_emploi + '">Prendre contact</button>';
                } else {
                    contenu = '<button type="button" class="btn btn-secondary btn-fixed-gauche " data-id="' + Id_emploi + '">Prendre contact</button>' +
                        '<button  type="button" class="btn btn-danger btn-fixed-droite Supprimer_emploi" data-id="' + Id_emploi + '">Supprimer</button>';
                }
                $('#'+ Id_emploi).html(contenu);
            }
        });
    }


    $(document).on('click', '.Supprimer_emploi', function() {
        var emploiId = $(this).data('id');
        $.ajax({
            url: 'Supprimer_emploi.php',
            type: 'POST',
            data: { 'Id_emploi': emploiId },

            success: function(response) {
                window.location.href = 'jobs.php';

            },
            error: function() {
                alert('error');

            }
        });

    });

    $(document).on('click', '.Contacter_entreprise', function() {
        var emploiId = $(this).data('id');
        $.ajax({
            url: 'contacter_entreprise.php',
            type: 'POST',
            data: { 'IDemploi': emploiId },
            success: function(response) {
                window.location.href = 'messaging.php';
            },
            error: function() {

            }
        });

    });

</script>

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

    <!-- Emplois -->
    <?php

    $database = "webdyna2024";

    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    echo '<div class="section">

            <h1>Emplois</h1>
            
            
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ajout_emploi">Ajouter un emploi sur le marché</button>
            
            <br>
            <br>
          
            
            <div class="row">';

                $affichage_offre_emplois = "SELECT * FROM emploi ORDER BY type";
                $result_affichage_offre_emplois = mysqli_query($db_handle, $affichage_offre_emplois);

                while ($emploi = mysqli_fetch_assoc($result_affichage_offre_emplois)){
                    $identifiant_entreprise = $emploi['identifiant_utilisateur'];
                    $nom_de_l_entreprise = "SELECT nom,prenom FROM utilisateur WHERE identifiant_utilisateur = $identifiant_entreprise";
                    $result_nom_de_l_entreprise = mysqli_query($db_handle, $nom_de_l_entreprise);

                    $nom_entreprise = mysqli_fetch_assoc($result_nom_de_l_entreprise);


                    echo '<div class="col-md-4">
                        <div class="card text-white bg-primary mb-3 h-99 mx-1">
                            <div class="card-body">';

                                echo '<h5 class="card-title"><b>'.$emploi['nom'].'</b></h5>';
                                echo'<h6 class="card-subtitle mb-2 text-muted"><i>'.$emploi['type'].'</i></h6>';
                                echo'<h6 class="card-subtitle mb-2 ">Proposé par '.$nom_entreprise['prenom'].' '.$nom_entreprise['nom'].'</h6>';
                                echo'<p class="card-text">'.$emploi['description'].'</p>';


                                echo '<div id="'.$emploi['identifiant_emploi'].'"></div>';

                                echo '<script>Gestion_bouton_supp_et_contacter('.$identifiant_entreprise.','.$emploi['identifiant_emploi'].')</script><br>';


                            echo '</div>
                        </div>
                    </div><br>';
                }
            echo'</div>
    </div>';

    if (isSet($_POST['new_emploi'])) {
        $id_user = $_SESSION['identifiant_utilisateur'];

        $nom = str_replace("'","''",$_POST['nom_emploi']);
        $description = str_replace("'","''",$_POST['description_emploi']);
        $type = str_replace("'","''",$_POST['type_emploi']);


        $nouvel_emploi = "INSERT INTO emploi (nom, description, type, identifiant_utilisateur) VALUES (\"$nom\", \"$description\", \"$type\",\"$id_user\")";
        $result_nouvel_emploi = mysqli_query($db_handle, $nouvel_emploi);

        echo "<script>window.location.href = 'jobs.php';</script>";


    }



    mysqli_close($db_handle);

    ?>
    <!-- Page modal d'ajout d'emploi -->
    <div class="modal fade" id="ajout_emploi" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h1 class="modal-title fs-5" id="formation">Ajouter un emploi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form class="row g-3" method="POST" action="jobs.php">


                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" name="nom_emploi" placeholder="Nom de l'emploi">
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control" name="type_emploi" rows="3" placeholder="CDD, CDI, stage, alternance ...">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description_emploi" rows="3" placeholder="Décrivez l'emploi, le salaire, les conditions de travail..."></textarea>
                    </div>


                    <button type="submit" name="new_emploi" class="btn btn-primary mb-3">Ajouter</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-3 mt-4 text-muted border-top">
        © 2024 ECE In <br>
        <small> <i>
                <a href="mailto:contact@ecein.fr">contact@ecein.fr</a> <br>
                01 44 39 06 00 <br>
                10 rue Sextius Michel, Paris 15 <br>
            </i> </small>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
