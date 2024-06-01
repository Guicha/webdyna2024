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
                $sql = "SELECT * FROM utilisateur WHERE identifiant_utilisateur = $Le_mec_qui_est_co";

                $result = mysqli_query($db_handle, $sql);

                while ($data = mysqli_fetch_assoc($result)) {

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

                    echo '<h1 class="h3 border-top"><b>Formations/Activités</b></h1>';

                    $sql2 = "SELECT * FROM formation WHERE identifiant_utilisateur = $Le_mec_qui_est_co ORDER BY date_debut DESC";

                    $result2 = mysqli_query($db_handle, $sql2);

                    echo'<br>';
                    echo'<div class="container border-bottom">';
                    echo'<div class="row">';

                    while ($data = mysqli_fetch_assoc($result2)) {
                        echo'<div class="col-md-4  ">';
                            echo '<div class="card text-white bg-secondary mb-3">';
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

                                    $sql3 = "SELECT * FROM projet WHERE identifiant_formation = $formation ORDER BY date DESC";
                                    $result3 = mysqli_query($db_handle, $sql3);

                                    while($data3 = mysqli_fetch_assoc($result3)) {

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
            }else {
                echo "Database not found";
            }
            mysqli_close($db_handle);
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
            $database = "webdyna2024";

            $Le_mec_qui_est_co = $_SESSION['identifiant_utilisateur'];

            $db_handle = mysqli_connect('localhost', 'root', '');
            $db_found = mysqli_select_db($db_handle, $database);

            if($db_found) {
                $sql = "SELECT * FROM Utilisateur WHERE identifiant_utilisateur = $Le_mec_qui_est_co";

                $result = mysqli_query($db_handle, $sql);

                while ($data = mysqli_fetch_assoc($result)) {
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
                    echo '</div>'.'<br>';

                    echo '<h1 class="h3 border-top"><b>Informations</b></h1>';


                    echo '<div class="form-group">';
                    echo'<label for="nom"><b>Nom</b></label>';
                    echo '<input type="text" class="form-control" name="nom" value='.$data['nom'].'>';


                    echo '<div class="form-group">';
                    echo'<label for="prenom"><b>Prenom</b></label>';
                    echo '<input type="text" class="form-control" name="prenom" value='.$data['prenom'].'>';


                    echo '<div class="form-group">';
                    echo'<label for="email"><b>Adresse Email</b></label>';
                    echo '<input type="text" class="form-control" name="email" value='.$data['email'].'>';


                    echo '<div class="form-group">';
                    echo'<label for="mdp"><b>Mot de Passe</b></label>';
                    echo '<input type="text" class="form-control" name="mdp" value='.$data['mdp'].'>';


                    echo '<div class="form-group">';
                    echo'<label for="bio"><b>Biographie</b></label>';
                    $bio = $data['bio'];

                    echo "<textarea class='form-control' name='bio' placeholder=".$bio.">".$bio."</textarea>";
                    echo '<br><div class="d-flex justify-content-center">';
                    echo '<button type="submit" name="envoie_des_données" id="save" class="btn btn-success" onclick="Sauvegarder()">Enregistrer mes modifications</button>';
                    echo '</div>';

                    echo '<br><h1 class="h3 border-top"><b>Formations/Activités</b></h1>';




                    $sql2 = "SELECT * FROM formation WHERE identifiant_utilisateur = $Le_mec_qui_est_co ORDER BY date_debut DESC";

                    $result2 = mysqli_query($db_handle, $sql2);

                    echo'<br>';
                    echo'<div class="container border-bottom">';
                    echo'<div class="row">';

                    while ($data = mysqli_fetch_assoc($result2)) {

                        $formation = $data['identifiant_formation'];

                        $_SESSION['formation_actuelle'] = $formation;

                        echo'<div class="col-md-4  ">';
                        echo '<div class="card text-white bg-secondary mb-3">';
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



                        $sql3 = "SELECT * FROM projet WHERE identifiant_formation = $formation ORDER BY date DESC";
                        $result3 = mysqli_query($db_handle, $sql3);

                        while($data3 = mysqli_fetch_assoc($result3)) {

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
                            echo '<button class=" btn btn-danger position-absolute top-0 end-0 deleteButton2" data-id="'.$data3['identifiant_projet'].'">X</button>';

                            echo'<p class="card-text">'.$data3['description'].'</p>';
                            echo'</div>';
                            echo'</div>';
                        }
                        echo '<button class=" btn btn-danger position-absolute top-0 end-0 deleteButton" data-id="'.$data['identifiant_formation'].'">X</button>';

                        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajout_projet">Ajouter un projet</button>';





                        echo'</div>';
                        echo'</div>';
                    }
                    echo'<div class="col-md-4  ">';
                    echo '<div class="card text-white bg-secondary mb-3">';

                    echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ajout_formation">+</button>';
                    echo '</div>';
                    echo '</div>';
                    }

                echo '</form>';

                echo '<div class="modal fade" id="ajout_formation" tabindex="-1">';
                echo '<div class="modal-dialog modal-lg">';
                echo '<div class="modal-content">';

                echo '<div class="modal-header">';
                echo '<h1 class="modal-title fs-5" id="formation">Ajouter une formation</h1>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';

                echo '<div class="modal-body">';

                echo '<form class="row g-3" method="POST" ">';

                echo '<div class="form-group">';
                echo '<label for="nom">Nom</label>';
                echo '<input type="text" class="form-control" name="nom_de_formation" placeholder="Nom de la formation">';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="description">Description</label>';
                echo '<textarea class="form-control" name="description" rows="3" placeholder="Décrivez la formation"></textarea>';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="dateDebut">Date de début</label>';
                echo '<input type="date" class="form-control" name="dateDebut">';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="dateFin">Date de fin</label>';
                echo '<input type="date" class="form-control" name="dateFin">';
                echo '</div>';
                echo '<button type="submit" name="newformation" class="btn btn-primary mb-3">Ajouter</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';




                echo '<div class="modal fade" id="ajout_projet" tabindex="-1">';
                echo '<div class="modal-dialog modal-lg">';
                echo '<div class="modal-content">';

                echo '<div class="modal-header">';
                echo '<h1 class="modal-title fs-5" id="formation">Ajouter un projet</h1>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';

                echo '<div class="modal-body">';

                echo '<form class="row g-3" method="POST" ">';

                echo '<div class="form-group">';
                echo '<label for="nom">Nom</label>';
                echo '<input type="text" class="form-control" name="nom_de_projet" placeholder="Nom du projet">';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="description">Description</label>';
                echo '<textarea class="form-control" name="description" rows="3" placeholder="Décrivez le projet"></textarea>';
                echo '</div>';

                echo '<div class="form-group">';
                echo "<label for='dateDebut'>Date (seul le mois et l'année importe)</label>";
                echo '<input type="date" class="form-control" name="date_projet">';
                echo '</div>';

                echo '<button type="submit" name="newprojet" class="btn btn-primary mb-3">Ajouter</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


            }
            if (isSet($_POST['newformation'])) {
                $nom = $_POST['nom_de_formation'];
                $description = $_POST['description'];
                $datedebut = $_POST['dateDebut'];
                $datefin = $_POST['dateFin'];

                if($db_found) {
                    $test_de_presence = "SELECT nom FROM formation WHERE nom =".$nom;
                    $result_presence = mysqli_query($db_handle, $test_de_presence);

                    if (empty($result_presence)) {
                        $sql4 = "INSERT INTO formation (`identifiant_formation`, `nom`, `description`, `date_debut`, `date_fin`, `identifiant_utilisateur`) VALUES (NULL, '" . $nom . "', '" . $description . "', '" . $datedebut . "', '" . $datefin . "', '" . $Le_mec_qui_est_co . "')";
                        $result4 = mysqli_query($db_handle, $sql4);

                        echo "<script>
                            $('#save').click();
                            Editer()
                        </script>";
                    }
                }
            }
            if (isSet($_POST['newprojet'])) {
                $nom = $_POST['nom_de_projet'];
                $description = $_POST['description'];
                $date_de_projet = $_POST['date_projet'];

                if($db_found) {
                    $sql5 = "INSERT INTO `projet` (`identifiant_projet`, `nom`, `description`, `date`, `identifiant_formation`) VALUES (NULL, '" . $nom . "', '" . $description . "', '" . $date_de_projet ."', '" . $_SESSION['formation_actuelle'] . "')";
                    $result5 = mysqli_query($db_handle, $sql5);

                    echo "<script>
                            $('#save').click();
                            Editer()
                        </script>";
                }
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
                    $tailleMax = 5 * 1024 * 1024; // 5MB
                    if ($tailleFichier > $tailleMax) {
                        die();
                    }

                    $dossier = 'images/';
                    $chemin = $dossier . basename($nomFichier);

                    if (move_uploaded_file($tmpFichier, $chemin)) {
                        echo " ";
                    } else {
                        echo "Erreur : Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
                    }

                    $requete = "UPDATE Utilisateur SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',mdp='".$_POST['mdp']."',email='".$_POST['email']."',bio='".$_POST['bio']."',photo='".$chemin."' WHERE identifiant_utilisateur=$Le_mec_qui_est_co";
                }else{
                    $requete = "UPDATE Utilisateur SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',mdp='".$_POST['mdp']."',email='".$_POST['email']."',bio='".$_POST['bio']."' WHERE identifiant_utilisateur=$Le_mec_qui_est_co";
                }

                mysqli_query($db_handle, $requete);

                echo "<script>if (!localStorage.getItem('pageRefreshed')) {
                                 localStorage.setItem('pageRefreshed', 'true');
                                 location.reload();
                            }else {
                                  localStorage.removeItem('pageRefreshed');
                            }</script>";
            }


            mysqli_close($db_handle);
            ?>

            <script>

                $(document).on('click', '.deleteButton', function() {
                    var formationId = $(this).data('id'); // Récupérez l'identifiant de la formation
                    $.ajax({
                        url: 'supprimer_formation.php', // Le chemin vers votre script PHP
                        type: 'POST',
                        data: { 'IDformation': formationId },
                        success: function(response) {
                            $('#save').click();
                        },
                        error: function() {
                            alert('Une erreur est survenue lors de la requête AJAX.');
                        }
                    });

                });

                $(document).on('click', '.deleteButton2', function() {
                    var projetId = $(this).data('id');
                    $.ajax({
                        url: 'supprimer_projet.php',
                        type: 'POST',
                        data: { 'IDprojet': projetId },
                        success: function(response) {
                            $('#save').click();
                        },
                        error: function() {
                            alert('Une erreur est survenue lors de la requête AJAX.');
                        }
                    });

                });
            </script>



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