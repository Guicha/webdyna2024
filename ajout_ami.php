<?php

require "verif_session.php";

include "liaison_bdd.php";

if (isset($_POST['connecter'])) {

    $id_ami = $_POST['identifiant_ami'];
    $id_utilisateur = $_SESSION['identifiant_utilisateur'];

    $sql = "INSERT INTO `ami`(`identifiant_ami`, `identifiant_utilisateur`) VALUES ($id_ami,$id_utilisateur)";
    $result = mysqli_query($conn, $sql);

    header('Location: network.php');
}

?>