<?php

include "liaison_bdd.php";

session_start();

if (empty($_SESSION)) {
    header('Location: login.html');

} else {

    $sql = "select * from utilisateur where identifiant_utilisateur = " . $_SESSION['identifiant_utilisateur'];

    $res = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($res);

    $_SESSION['identifiant_utilisateur'] = $row['identifiant_utilisateur'];
    $_SESSION['type'] = $row['type'];
    $_SESSION['nom'] = $row['nom'];
    $_SESSION['prenom'] = $row['prenom'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['mdp'] = $row['mdp'];
    $_SESSION['photo'] = $row['photo'];
    $_SESSION['bio'] = $row['bio'];
    $_SESSION['cv'] = $row['cv'];

}

?>
