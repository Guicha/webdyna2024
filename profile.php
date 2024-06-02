<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">


    <title>Profil - ECE In</title>

</head>
<?php

require "verif_session.php";

?>

<script>
    function Editer() {
        document.getElementById('infoAffichage').classList.add('hidden');
        document.getElementById('infoModification').classList.remove('hidden');
    }

    function Sauvegarder() {

        document.getElementById('infoModification').classList.add('hidden');
        document.getElementById('infoAffichage').classList.remove('hidden');

    }

    $(document).on('click', '.deleteformation', function() {
        var formationId = $(this).data('id');
        $.ajax({
            url: 'supprimer_formation.php',
            type: 'POST',
            data: { 'IDformation': formationId },
            success: function(response) {
                $('#save').click();
            },
            error: function() {
                alert('Changer de Navigateur pour avoir une suppression opérationel de formation !');
            }
        });

    });

    $(document).on('click', '.deleteprojet', function() {
        var projetId = $(this).data('id');
        $.ajax({
            url: 'supprimer_projet.php',
            type: 'POST',
            data: { 'IDprojet': projetId },
            success: function(response) {
                $('#save').click();
            },
            error: function() {
                alert('Changer de Navigateur pour avoir une suppression opérationel de projet !');
            }
        });

    });

    $(document).on('click', '.boutonProjet', function() {
        var formationduprojet = $(this).data('id');
        $.ajax({
            url: 'form_newprojet.php',
            type: 'GET',
            data: { 'IDformation': formationduprojet },
            success: function(response) {
                $('#donnees_projet').html(response);
            },
            error: function() {
            }
        });

    });

    $(document).on('click', '.CV_download', function(){
        var Path_cv_Id = this.getAttribute('data-id');
        if(Path_cv_Id === ''){
            alert("Vous n'avez pas de CV existant !");
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

    $(document).on('click', '.CV_generate', function() {

        $('#save').click();
        $.ajax({
            url: 'generation_cv.php',
            type: 'GET',
            data: { 'envoi_information': 1 },
            success: function(response) {

            },
            error: function() {
            }
        });
    });


</script>

<body>
<div class="container">
    <!-- Bandeau du dessus -->
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
    <!-- Body -->
    <div class="section">
        <h1>Mon profil</h1>
        <br>


        <!-- Affichage info de l'utilisateur -->
        <div id="infoAffichage">
            <?php

            $database = "webdyna2024";

            $Le_mec_qui_est_co = $_SESSION['identifiant_utilisateur'];

            $db_handle = mysqli_connect('localhost', 'root', '');
            $db_found = mysqli_select_db($db_handle, $database);

            if($db_found) {
                $affichage_profil = "SELECT * FROM utilisateur WHERE identifiant_utilisateur = $Le_mec_qui_est_co";

                $result_affichage_profil = mysqli_query($db_handle, $affichage_profil);

                while ($data = mysqli_fetch_assoc($result_affichage_profil)) {

                    echo '<div class="d-flex justify-content-center">';

                        if(empty($data['photo'])) {
                            echo '<img src="images\defaut.jpg" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                        }else{
                            $image = $data['photo'];
                            echo '<img src="'.$image.'" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                        }
                    echo '</div>';


                    echo '<h1 class="h3 border-top"><b>Informations</b></h1>';

                    echo '<div class="form-group">';
                        echo '<label for="nom"><b>Nom</b></label>';
                        echo  "<br>".$data['nom'] . "<br>";
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label for="prenom"><b>Prenom</b></label>';
                        echo  "<br>".$data['prenom'] . "<br>";
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label for="email"><b>Adresse Email</b></label>';
                        echo  "<br>".$data['email'] . "<br>";
                    echo '</div>';

                    $points = str_repeat('*',strlen($data['mdp']));

                    echo '<div class="form-group">';
                        echo '<label for="mdp"><b>Mot de passe</b></label>';
                        echo  "<br>".$points . "<br>";
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label for="bio"><b>Biographie</b></label>';
                        echo  "<br>".$data['bio'] . "<br><br>";
                    echo '</div>';

                    echo'<button class="btn btn-outline-primary CV_download" data-id="'.$data['cv'].'">Télécharger mon CV</button><br><br>';

                    echo '<h1 class="h3 border-top"><b>Formations/Activités</b></h1>';
                    echo'<br>';

                    $recherche_formation = "SELECT * FROM formation WHERE identifiant_utilisateur = $Le_mec_qui_est_co ORDER BY date_debut DESC";

                    $result_recherche_formation = mysqli_query($db_handle, $recherche_formation);


                    echo'<div class="container border-bottom">';

                        echo'<div class="row">';

                            while ($data = mysqli_fetch_assoc($result_recherche_formation)) {
                                echo'<div class="col-md-4  ">';
                                    echo '<div class="card text-white bg-secondary mb-3 ">';
                                        echo'<div class="card-body">';
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

                                        $recherche_projet = "SELECT * FROM projet WHERE identifiant_formation = $formation ORDER BY date DESC";
                                        $result_recherche_projet = mysqli_query($db_handle, $recherche_projet);

                                        while($data3 = mysqli_fetch_assoc($result_recherche_projet)) {

                                            echo '<div class="card mb-3">';
                                                echo'<div class="card-body">';
                                                    echo'<h5 class="card-title"><u>Projet : '.$data3['nom'].'</u></h5>';

                                                    $date_projet = explode('-', $data3['date']);
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
                                                            $date_de_projet_normal = date("F Y", strtotime($data3['date']));
                                                            echo'<h6 class="card-subtitle mb-2 text-muted"><i>'.$date_de_projet_normal.'</i></h6>';
                                                        }
                                                    }
                                                    echo'<p class="card-text">'.$data3['description'].'</p>';

                                                echo'</div>';
                                            echo'</div>';
                                        }

                                    echo'</div>';
                                echo'</div>';
                            }
                        echo'</div><br>';
                    echo'</div>';
                }
            }

            ?>
            <br>

            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" onclick="Editer()">Modifier mes informations</button>
            </div>


            <!-- Footer -->
            <footer class="pt-3 mt-4 text-muted border-top">
                © 2024 ECE In
            </footer>

        </div>





        <!-- Modification de l'utilisateur -->
        <div id="infoModification" class="hidden">

            <?php

            if($db_found) {
                $recherche_information_utilisateur= "SELECT * FROM Utilisateur WHERE identifiant_utilisateur = $Le_mec_qui_est_co";

                $result_recherche_information_utilisateur = mysqli_query($db_handle, $recherche_information_utilisateur);

                while ($data = mysqli_fetch_assoc($result_recherche_information_utilisateur)) {
                    echo '<div class="d-flex justify-content-center">';

                        if(empty($data['photo'])) {

                            echo '<img src="images\defaut.jpg" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                        }else{

                            $image = $data['photo'];
                            echo '<img src="'.$image.'" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                        }

                    echo '</div>';


                    echo '<form method="post" enctype="multipart/form-data">';

                    echo '<div class="d-flex justify-content-center mt-3">' ;

                        echo '<input type="file" name="Nouvelleimage">';

                    echo '</div><br>';


                    echo '<h1 class="h3 border-top"><b>Informations</b></h1>';

                    echo'<label for="nom"><b>Nom</b></label>';
                    echo '<input type="text" class="form-control" name="nom" value='.$data['nom'].'>';


                    echo'<label for="prenom"><b>Prenom</b></label>';
                    echo '<input type="text" class="form-control" name="prenom" value='.$data['prenom'].'>';


                    echo'<label for="email"><b>Adresse Email</b></label>';
                    echo '<input type="text" class="form-control" name="email" value='.$data['email'].'>';


                    echo'<label for="mdp"><b>Mot de Passe</b></label>';
                    echo '<input type="text" class="form-control" name="mdp" value='.$data['mdp'].'>';

                    echo'<label for="bio"><b>Biographie</b></label>';
                    $bio = $data['bio'];

                    echo "<textarea class='form-control' name='bio' placeholder=".$bio.">".$bio."</textarea><br>";



                    echo'<label for="import_CV"><b>Importer votre CV </b></label>';


                    echo '<div class="d-flex justify-content mt-3">' ;

                        echo '<input type="file" name="NouveauCV">';

                    echo '</div><br>';

                    echo'<label for="import_CV"><b>Générer votre CV </b></label><br>';

                    echo'<button class="btn btn-outline-primary CV_generate" >Générer mon CV</button><br><br>';


                    echo '<div class="d-flex justify-content-center">';

                        echo '<button type="submit" name="envoie_des_données" id="save" class="btn btn-success" onclick="Sauvegarder()">Enregistrer mes modifications</button>';

                    echo '</div>';
                    echo '</form>';



                    echo '<br><h1 class="h3 border-top"><b>Formations/Activités</b></h1>';

                    $recherche_formation = "SELECT * FROM formation WHERE identifiant_utilisateur = $Le_mec_qui_est_co ORDER BY date_debut DESC";

                    $result_recherche_formation = mysqli_query($db_handle, $recherche_formation);

                    echo'<div class="container border-bottom">';
                        echo'<div class="row">';

                        while ($data = mysqli_fetch_assoc($result_recherche_formation)) {

                            $formation = $data['identifiant_formation'];


                            echo'<div class="col-md-4  ">';
                                echo'<div class="card text-white bg-secondary mb-3 ">';
                                    echo'<div class="card-body">';
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



                                    $recherche_projet = "SELECT * FROM projet WHERE identifiant_formation = $formation ORDER BY date DESC";
                                    $result_recherche_projet = mysqli_query($db_handle, $recherche_projet);

                                    while($data3 = mysqli_fetch_assoc($result_recherche_projet)) {

                                        echo '<div class="card mb-3 ">';
                                            echo'<div class="card-body">';
                                                echo'<h5 class="card-title"><u>Projet : '.$data3['nom'].'</u></h5>';

                                                $date_projet = explode('-', $data3['date']);
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
                                                        $date_de_projet_normal = date("F Y", strtotime($data3['date']));
                                                        echo'<h6 class="card-subtitle mb-2 text-muted"><i>'.$date_de_projet_normal.'</i></h6>';

                                                    }

                                                }
                                                echo'<p class="card-text">'.$data3['description'].'</p>';

                                                echo '<button class="btn btn-close position-absolute top-0 end-0 deleteprojet" data-id="'. $data3['identifiant_projet'] .'"></button>';

                                            echo'</div>';
                                        echo'</div>';
                                    }
                                echo '<button class=" btn btn-close position-absolute top-0 end-0 deleteformation" data-id="'.$data['identifiant_formation'].'"></button>';

                                echo '<button type="button" class="btn btn-success form_projet boutonProjet" data-bs-toggle="modal" data-bs-target="#ajout_projet" data-id="'.$data['identifiant_formation'].'">Ajouter un projet</button>';

                                echo'</div>';
                            echo'</div>';
                        }

                    echo'<div class="col-md-4  ">';
                        echo '<div class="card text-white bg-secondary mb-3">';

                            echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ajout_formation">+</button>';

                        echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';

            }?>

            <!-- Page modal d'ajout de formation -->
            <div class="modal fade" id="ajout_formation" tabindex="-1">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h1 class="modal-title fs-5" id="formation">Ajouter une formation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>

                        <div class="modal-body">

                            <form class="row g-3" method="POST" ">

                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom_de_formation" placeholder="Nom de la formation">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Décrivez la formation"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="dateDebut">Date de début</label>
                                <input type="date" class="form-control" name="dateDebut">
                            </div>

                            <div class="form-group">';
                                <label for="dateFin">Date de fin</label>';
                                <input type="date" class="form-control" name="dateFin">
                            </div>

                            <button type="submit" name="newformation" class="btn btn-primary mb-3">Ajouter</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Page modal d'ajout de projet -->
            <div class="modal fade" id="ajout_projet" tabindex="-1">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h1 class="modal-title fs-5" id="projet">Ajouter un projet</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>

                        <div class="modal-body">

                            <div class="donnees_projet" id = "donnees_projet">

                                <!-- Formulaire de nouveau projet dans le fichier form_newprojet.php -->

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <?php


            if (isSet($_POST['newformation'])) {

                $nom = str_replace("'","''",$_POST['nom_de_formation']);
                $description = str_replace("'","''",$_POST['description']);
                $datedebut = $_POST['dateDebut'];
                $datefin = $_POST['dateFin'];


                $nouvelle_formation = "INSERT INTO formation (`nom`, `description`, `date_debut`, `date_fin`, `identifiant_utilisateur`) VALUES ('" . $nom . "', '" . $description . "', '" . $datedebut . "', '" . $datefin . "', '" . $Le_mec_qui_est_co . "')";
                $result_nouvelle_formation = mysqli_query($db_handle, $nouvelle_formation);

                echo "<script>
                      $('#save').click();
                      </script>";

            }

            if (isSet($_POST['envoie_des_données'])) {

                $_POST['nom'] = str_replace("'","''",$_POST['nom']);
                $_POST['prenom'] = str_replace("'","''",$_POST['prenom']);
                $_POST['email'] = str_replace("'","''",$_POST['email']);
                $_POST['mdp'] = str_replace("'","''",$_POST['mdp']);
                $_POST['bio'] = str_replace("'","''",$_POST['bio']);

                if (isset($_FILES['Nouvelleimage']) && $_FILES['Nouvelleimage']['error'] != UPLOAD_ERR_NO_FILE){

                    $nomFichier = $_FILES['Nouvelleimage']['name'];
                    $typeFichier = $_FILES['Nouvelleimage']['type'];
                    $tailleFichier = $_FILES['Nouvelleimage']['size'];
                    $tmpFichier = $_FILES['Nouvelleimage']['tmp_name'];

                    // Vérifiez si le fichier est une image
                    $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
                    $extensionFichier = pathinfo($nomFichier, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extensionFichier), $extensionsAutorisees)) {
                        die();
                    }

                    // Vérifiez la taille du fichier - 5MB maximum
                    $tailleMax = 5 * 1024 * 1024;
                    if ($tailleFichier > $tailleMax) {
                        die();
                    }

                    $dossier = 'images/';
                    $chemin = $dossier . basename($nomFichier);

                    move_uploaded_file($tmpFichier, $chemin);

                    $modification_information = "UPDATE utilisateur SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',mdp='".$_POST['mdp']."',email='".$_POST['email']."',bio='".$_POST['bio']."',photo='".$chemin."' WHERE identifiant_utilisateur=$Le_mec_qui_est_co";

                }else{
                    $modification_information = "UPDATE utilisateur SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',mdp='".$_POST['mdp']."',email='".$_POST['email']."',bio='".$_POST['bio']."' WHERE identifiant_utilisateur=$Le_mec_qui_est_co";
                }

                mysqli_query($db_handle, $modification_information);

                if (isset($_FILES['NouveauCV']) && $_FILES['NouveauCV']['error'] != UPLOAD_ERR_NO_FILE){

                    $nomFichier = $_FILES['NouveauCV']['name'];
                    $typeFichier = $_FILES['NouveauCV']['type'];
                    $tailleFichier = $_FILES['NouveauCV']['size'];
                    $tmpFichier = $_FILES['NouveauCV']['tmp_name'];

                    // Vérifiez si le fichier est un fichier pdf ou HTML
                    $extensionsAutorisees = array('HTML', 'pdf');
                    $extensionFichier = pathinfo($nomFichier, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extensionFichier), $extensionsAutorisees)) {
                        die();
                    }

                    // Vérifiez la taille du fichier - 100MB maximum
                    $tailleMax = 100 * 1024 * 1024;
                    if ($tailleFichier > $tailleMax) {
                        die();
                    }

                    $dossier = 'fichiers/';
                    $chemin = $dossier . basename($nomFichier).'';

                    move_uploaded_file($tmpFichier, $chemin);


                    $importation_CV = "UPDATE `utilisateur` SET `cv` = '".$chemin."' WHERE `utilisateur`.`identifiant_utilisateur` = $Le_mec_qui_est_co";

                    mysqli_query($db_handle, $importation_CV);

                }



                echo "<script>
                            window.location.href = 'profile.php';
                </script>";

            }
            mysqli_close($db_handle);
            ?>

            <!-- Footer -->
            <footer class="pt-3 mt-4 text-muted border-top">
                © 2024 ECE In
            </footer>

        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


</body>
</html>