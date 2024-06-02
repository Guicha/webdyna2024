<?php

require "verif_session.php";

include "liaison_bdd.php";

if (isset($_POST['deconnecter'])) {

    $id_ami = $_POST['identifiant_ami'];
    $id_utilisateur = $_SESSION['identifiant_utilisateur'];

    $sql = "DELETE FROM `ami` WHERE identifiant_ami = $id_ami AND identifiant_utilisateur = $id_utilisateur";
    $result = mysqli_query($conn, $sql);

    header('Location: network.php');
}


?>
