<?php

session_start();

include "liaison_bdd.php";

if (isset($_POST['connexion'])) {

    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $sql = "SELECT * FROM utilisateur WHERE email=\"$email\"";
    $res = mysqli_query($conn, $sql);

    echo "<div class=\"card mx-4 mx-md-5 shadow-5-strong bg-body-tertiary\" style=\"margin-top: -100px; backdrop-filter: blur(30px);\">";

    echo "<div class=\"card-body py-5 px-md-5\">";

    echo "<div class=\"row d-flex justify-content-center\">";

    echo "<div class=\"col-lg-8\">";

    if (mysqli_num_rows($res) > 0) {

        $row = mysqli_fetch_assoc($res);

        $mdp_stocke = $row['mdp'];

        if ($mdp == $mdp_stocke) {

            $_SESSION['identifiant_utilisateur'] = $row['identifiant_utilisateur'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['mdp'] = $row['mdp'];
            $_SESSION['photo'] = $row['photo'];
            $_SESSION['bio'] = $row['bio'];
            $_SESSION['cv'] = $row['cv'];

            echo "<h2 class=\"fw-bold mb-5\">Connexion réussie ! Bonjour " . $_SESSION['prenom'] ." !</h2>";

            if ($row['type'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }

        } else {

            echo "<h2 class=\"fw-bold mb-5\">Mot de passe incorrect</h2>";

            echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button></a>";
        }

    } else {
        echo "<h2 class=\"fw-bold mb-5\">Adresse email ou mot de passe incorrect</h2>";

        echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button></a>";
    }

    echo "</div>";

    echo "</div>";

    echo "</div>";

    echo "</div>";
}

?>
