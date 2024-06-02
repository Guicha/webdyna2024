<?php

require "verif_session.php";

include "liaison_bdd.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Accueil - ECE In</title>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
        <h1>Accueil</h1>

        <?php

        echo "<p>Bienvenue " . $_SESSION['prenom'] . " !</p>";

        ?>

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="images/vivatech.jpeg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Vivatech 2024</h5>
                        <p>La semaine dernière à eu lieu VivaTech 2024.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="images/shrek.jpg" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Shrek 2024</h5>
                        <p>La semaine dernière à eu lieu Shrek 2024.</p>
                    </div>
                </div>
                <!-- Ajoutez d'autres éléments de carousel ici -->
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        <h2 class="mt-4">Événements récents</h2>
        <!-- Liste des événements -->


    <h2 class="mt-4">Mur de publications</h2>



        <div class="row row-cols-1 row-cols-md-2 g-4">

            <?php

            $identifiant_utilisateur = $_SESSION['identifiant_utilisateur'];

            $sql = "SELECT * FROM post ORDER BY post.date DESC";

            $result = mysqli_query($conn, $sql);

            while ($data = mysqli_fetch_assoc($result)) {

                $id_post = $data['identifiant_post'];
                $media = $data['media'];
                $prive = $data['prive'];
                $auteur_id = $data['identifiant_utilisateur'];

                $sql_auteur = "SELECT * FROM utilisateur WHERE identifiant_utilisateur = '" . $auteur_id . "'";
                $result_auteur = mysqli_query($conn, $sql_auteur);

                $data_auteur = mysqli_fetch_assoc($result_auteur);

                $auteur_prenom = $data_auteur['prenom'];
                $auteur_nom = $data_auteur['nom'];

                $ami = 0;

                // On vérifie d'abord si l'utilisateur actuel est ami avec l'utilisateur sur le mur, ou qu'il s'agit de lui-même
                $sql_ami = "SELECT * FROM ami WHERE ami.identifiant_utilisateur=" . $auteur_id . " AND ami.identifiant_ami=" . $_SESSION['identifiant_utilisateur'];
                $result_ami = mysqli_query($conn, $sql_ami);

                $num_rows = mysqli_num_rows($result_ami);

                // Le propriétaire du mur a ajouté l'utilisateur actuel en ami, ou il s'agit de l'utilisateur lui meme consultant son mur
                if ($num_rows != 0 or $_SESSION['identifiant_utilisateur'] == $auteur_id) {

                   $ami = 1;

                } else { // Le cas contraire

                    $ami = 0;
                }

                if (!$prive or ($prive and $ami)) {

                    // On détermine si c'est une vidéo ou une photo
                    $extension = pathInfo($media, PATHINFO_EXTENSION);

                    if ($extension == "mp4" or $extension == "mov" or $extension == "aif" or $extension == "mkv") {

                        $video = 1;

                    } else {

                        $video = 0;
                    }

                    echo "<div class='col'>";

                    echo "<div class='card'>";

                    if ($video) {

                        echo "<video src=$media class='card-img-top' controls></video>";

                    } else {

                        echo "<img src=$media class='card-img-top'>";
                    }

                    echo "<div class='card-header'>" . $auteur_prenom . " " . $auteur_nom . " - " . $data['lieu'];

                    if ($prive) {

                        echo "<button type='button' class='btn btn-success float-end' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Publication privée'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye-slash-fill' viewBox='0 0 16 16'>
                                                <path d='m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z'/>
                                                <path d='M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z'/>
                                            </svg>
                                        </button>";

                    }

                    echo "</div>";

                    echo "<div class='card-body'>";

                    echo "<h5 class='card-title'>" . $data['titre'] . "</h5>";

                    echo "<p class='card-text'>" . $data['description'] . "</p>";

                    echo "</div>";

                    echo "<div class='card-footer'>";

                    echo "<small class='text-body-secondary'>" . $data['date'] . "</small>";

                    // Bouton supprimer
                    if ($_SESSION['identifiant_utilisateur'] == $auteur_id) {

                        echo "<form method='POST' action='supprimer_publication.php'>";

                        echo "<input type='hidden' name='identifiant_post' value=$id_post>";

                        echo "<button class='btn btn-secondary float-end' type='submit' name='supprimer'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                                            </svg>
                                        </button>";

                        echo "</form>";

                        echo "<div class='float-end'> &nbsp </div>";

                    }

                    // Bouton like
                    // On récupère le nombre de likes de la publication
                    $sql_likes = "SELECT COUNT(*) FROM likes WHERE identifiant_post=$id_post";
                    $result_likes = mysqli_query($conn, $sql_likes);

                    $row = mysqli_fetch_row($result_likes);

                    $nb_likes = $row['0'];

                    echo "<form method='POST' action='ajout_like.php'>";

                    echo "<input type='hidden' name='identifiant_post' value='$id_post'>";

                    echo "<button class='btn btn-outline-danger float-end' type='submit' name='liker'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'/>
                                            </svg>
                                            $nb_likes
                                    </button>";

                    echo "</form>";

                    echo "<div class='float-end'> &nbsp </div>";

                    // Bouton commentaires
                    echo "<button class='btn btn-outline-primary float-end boutonCommentaires' data-bs-toggle='modal' data-bs-target='#modalCommentaires' value=$id_post>Commentaires</button>";

                    echo "<div class='modal fade' id='modalCommentaires' tabindex='-1'>
                                      <div class='modal-dialog modal-lg modal-dialog-scrollable'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h1 class='modal-title fs-5'>Commentaires</h1>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                          </div>
                                          <div class='modal-body'>

                                          <div class='list-group' id='affichage_commentaires'>
                                          ";





                    echo "</div>";

                    echo "</div>";

                    echo "</div>
                                      </div>
                                    </div>";

                    echo "</div>";

                    echo "</div>";

                    echo "</div>";


                }


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
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
<script>

    $(document).ready(function () {

        $('.boutonCommentaires').click(function () {

            var id_bouton = $(this).attr("value");

            chargerCommentaires(id_bouton);
        });


        function chargerCommentaires(id_post) {
            $.ajax({
                url: 'get_commentaires.php',
                method: 'GET',
                data: { id_post: id_post },
                success: function (response) {
                    $('#affichage_commentaires').html(response);
                }
            });
        }

    })

</script>

</body>
</html>

