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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
                                echo'<button class="btn btn-outline-primary CV_download btn-sm" data-id="'.$mur_cv.'">Télécharger le CV</button><br><br>';
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" >
                <div class="container">
                    <div class="row">
                    <h1>Formations/Activités</h1>

                    <?php

                    $sql_formation = "SELECT * FROM formation WHERE identifiant_utilisateur = $mur_identifiant_utilisateur ORDER BY date_debut DESC";

                    $result_formation = mysqli_query($conn, $sql_formation);

                    while ($data = mysqli_fetch_assoc($result_formation)) {
                    ?>

                    <div class="col-md-6  ">
                        <div class="card text-white bg-secondary mb-4 ">
                            <div class="card-body">
                                <?php
                                echo'<h5 class="card-title"><b>'.$data['nom'].'</b></h5>';

                                $date_de_debut_formation = date("F Y", strtotime($data['date_debut']));
                                if (date("Y", strtotime($data['date_fin']))=='-0001'){
                                echo'<h6 class="card-subtitle mb-2 text-muted"><i>Depuis '.$date_de_debut_formation.'</i></h6>';
                                }else{
                                $date_de_fin_formation = date("F Y", strtotime($data['date_fin']));
                                echo'<h6 class="card-subtitle mb-2 text-muted"><i>De '.$date_de_debut_formation.' à '.$date_de_fin_formation.'</i></h6>';
                                }

                                echo'<p class="card-text">'.$data['description'].'</p>';
                                echo'</div>';

                            $formation = $data['identifiant_formation'];

                            $sql_projet = "SELECT * FROM projet WHERE identifiant_formation = $formation ORDER BY date DESC";
                            $result_projet = mysqli_query($conn, $sql_projet);

                            while($data2 = mysqli_fetch_assoc($result_projet)) {

                            echo '<div class="card mb-4">';
                                echo'<div class="card-body">';
                                    echo'<h5 class="card-title"><u>Projet : '.$data2['nom'].'</u></h5>';

                                    $date_projet = explode('-', $data2['date']);
                                    $annee_projet = $date_projet[0];
                                    $mois_projet = $date_projet[1];

                                    if ($date_projet[0] == "0000"){
                                        echo'<h6 class="card-subtitle mb-2 text-muted"> </h6>';
                                    }
                                    else {
                                        if($date_projet[1]== "00"){
                                            echo'<h6 class="card-subtitle mb-2 text-muted"><i>En '.$date_projet[0].'</i></h6>';
                                        }
                                        else{
                                            $date_de_projet_normal = date("F Y", strtotime($data2['date']));
                                            echo'<h6 class="card-subtitle mb-2 text-muted"><i>'.$date_de_projet_normal.'</i></h6>';
                                        }
                                    }

                                    echo'<p class="card-text">'.$data2['description'].'</p>';

                                    echo'</div>';
                                echo'</div>';

                            }
                            echo'</div>';
                        echo'</div>';

                    }
                    ?>
                </div>

                <br>
                <div class="container border-bottom">
                    <div class="row">
                    </div>
                </div>

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
        <div class="container border-bottom">
            <div class="row">
            </div>
        </div>


        <div class="row">

            <h1>Publications</h1>

            <div class="col">
                <?php

                if ($_SESSION['identifiant_utilisateur'] == $mur_identifiant_utilisateur) {

                    echo "
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalPublier'>
                Publier
            </button>  
            ";

                    echo "<br>";
                }

                ?>
            </div>

        </div>




        <br>

        <div class="row row-cols-1 row-cols-md-2 g-4">

            <?php

                $identifiant_utilisateur = $_SESSION['identifiant_utilisateur'];

                // On vérifie d'abord si l'utilisateur est ami avec l'utilisateur sur le mur, ou qu'il s'agit de lui-même
                $sql_ami = "SELECT * FROM ami WHERE ami.identifiant_utilisateur=" . $mur_identifiant_utilisateur . " AND ami.identifiant_ami=" . $_SESSION['identifiant_utilisateur'];
                $result_ami = mysqli_query($conn, $sql_ami);

                $num_rows = mysqli_num_rows($result_ami);

                // Le propriétaire du mur a ajouté l'utilisateur actuel en ami, ou il s'agit de l'utilisateur lui meme consultant son mur
                if ($num_rows != 0 or $_SESSION['identifiant_utilisateur'] == $mur_identifiant_utilisateur) {

                    $sql = "SELECT * FROM post WHERE post.identifiant_utilisateur=$mur_identifiant_utilisateur ORDER BY post.date DESC";

                } else { // Le cas contraire

                    $sql = "SELECT * FROM post WHERE post.identifiant_utilisateur=$mur_identifiant_utilisateur AND post.prive=0 ORDER BY post.date DESC";
                }

                $result = mysqli_query($conn, $sql);

                while ($data = mysqli_fetch_assoc($result)) {

                    $id_post = $data['identifiant_post'];
                    $media = $data['media'];
                    $prive = $data['prive'];

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

                    echo "<div class='card-header'>" . $mur_prenom . " " . $mur_nom . " - " . $data['lieu'];

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
                    if ($_SESSION['identifiant_utilisateur'] == $mur_identifiant_utilisateur) {

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
            ?>

        </div>

        <br>

        <div class="modal fade" id="modalPublier" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">

                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalPublierTitre">Nouvelle Publication</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="nouvelle_publication.php" method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="champ_auteur" class="form-label">Auteur</label>
                                <?php
                                    echo "<input id='champ_auteur' class='form-control' type='text' placeholder='". $_SESSION['prenom'] . " " . $_SESSION['nom'] ."' disabled>";
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre</label>
                                <input type="text" name="titre_publication" class="form-control" id="titre" placeholder="Titre de la publication">
                            </div>

                            <div class="mb-3">
                                <label for="localisation" class="form-label">Localisation</label>
                                <input type="text" name="localisation_publication" class="form-control" id="localisation" placeholder="Localisation de la publication">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description_publication" id="description" rows="3" placeholder="Description brève de la publication"></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="prive" name="prive">
                                    <label class="form-check-label" for="prive">
                                        Publication privée
                                    </label>
                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="media" class="form-label">Media</label>
                                <input class="form-control form-control-sm" name="media_publication" id="media" type="file">
                            </div>

                            <?php
                                $identifiant_utilisateur = $_SESSION['identifiant_utilisateur'];

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

    $(document).on('click', '.CV_download', function(){
        var Path_cv_Id = this.getAttribute('data-id');
        if(Path_cv_Id === ''){
            alert("Cette individu n'a pas de CV existant!");
        }
        else{
            fetch(Path_cv_Id)
                .then(response => response.blob())
                .then(blob => {
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.download = 'CV.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                });
        }

    });


</script>

</body>
</html>
