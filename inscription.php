<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- MDB -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css"
        rel="stylesheet"
    />


</head>
<body>

<!-- Section: Design Block -->
<section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="
            background-image: url('images/shrek.jpg');
            height: 300px;
            ">

    </div>

</section>
<!-- Section: Design Block -->

<!-- MDB -->
<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.umd.min.js"
></script>
</body>
</html>


<?php

session_start();

include "liaison_bdd.php";

if (isset($_POST['inscription'])) {

    $prenom = $_POST['prenom'];
    $nom_famille = $_POST['nom_famille'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $conf_mdp = $_POST['conf_mdp'];


    $check = "select * from utilisateur where email=\"$email\"";

    $res = mysqli_query($conn, $check);

    echo "<div class=\"card mx-4 mx-md-5 shadow-5-strong bg-body-tertiary\" style=\"margin-top: -100px backdrop-filter: blur(30px)\">";

    echo "<div class=\"card-body py-5 px-md-5\">";

    echo "<div class=\"row d-flex justify-content-center\">";

    echo "<div class=\"col-lg-8\">";


    if (mysqli_num_rows($res) > 0) {

        echo "<h2 class=\"fw-bold mb-5\">Cette adresse email est déjà utilisée !</h2>";

        echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button></a>";


    } else {

        if ($mdp === $conf_mdp) {

            $sql = "insert into utilisateur(type,nom,prenom,email,mdp) values(\"user\", \"$nom_famille\", \"$prenom\", \"$email\",\"$mdp\")";

            $result = mysqli_query($conn, $sql);

            if ($result) {

                echo "<h2 class=\"fw-bold mb-5\">Inscription complétée !</h2>";

                echo "<a href='login.php'><button class='btn'>Se connecter</button></a>";

            } else {

                echo "<h2 class=\"fw-bold mb-5\">Adresse email déjà utilisée !</h2>";

                echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button></a>";
            }

        } else {

            echo "<h2 class=\"fw-bold mb-5\">Les mots de passe ne correspondent pas !</h2>";

            echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button></a>";
        }
    }

    echo "</div>";

    echo "</div>";

    echo "</div>";

    echo "</div>";
}


?>