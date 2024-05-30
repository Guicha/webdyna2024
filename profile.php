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


    <title>Profil - ECE In</title>

</head>
<?php

require "verif_session.php";

?>
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

                    if(empty($utilisateur['photo'])) {
                        echo '<img src="images\defaut.jpg" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                    }else{
                        $image = $data['photo'];
                        echo '<img src="$image" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                    }
                    echo '</div>';

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
                    echo  "<br>".$data['bio'] . "<br>";
                    echo '</div>';

                }
            }else {
                echo "Database not found";
            }
            mysqli_close($db_handle);
            ?>


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

                    if(empty($utilisateur['photo'])) {
                        echo '<img src="images\defaut.jpg" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                        $image = "images\defaut.jpg";

                    }else{
                        $image = $data['photo'];
                        echo '<img src="$image" class="img-thumbnail" alt="image de profil" style="width: 300px; height: 300px;">';
                    }

                    echo '</div>';

                    echo '<form method="post" >';
                    echo '<div class="d-flex justify-content-center mt-3">';
                    echo '<input type="file" name="Nouvelleimage">';
                    echo '</div>'.'<br>';


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
                    echo '<textarea class="form-control" name="bio" placeholder='.$bio.'>'.$bio.'</textarea>';

                    echo '<br><div class="d-flex justify-content-center">';
                    echo '<button type="submit" name="envoie_des_données" class="btn btn-success" onclick="Sauvegarder()">Enregistrer mes modifications</button>';
                    echo '</div>';
                    echo '</form>';
                    }
                }


            if (isSet($_POST['envoie_des_données'])) {

                $requete = "UPDATE Utilisateur SET nom='".$_POST['nom']."',prenom='".$_POST['prenom']."',mdp='".$_POST['mdp']."',email='".$_POST['email']."',bio='".$_POST['bio']."' WHERE identifiant_utilisateur=$Le_mec_qui_est_co";
                mysqli_query($db_handle, $requete);

                echo"<script>
                        if (!localStorage.getItem('pageRefreshed')) {
                        localStorage.setItem('pageRefreshed', 'true');
                        location.reload();
                        }else {
                        localStorage.removeItem('pageRefreshed');
                        }
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




