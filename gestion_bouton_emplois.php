<?php

require "verif_session.php";

if(isset($_GET['envoi_information']) && isset($_GET['id_entreprise'])) {

    $utilisateur = $_SESSION['identifiant_utilisateur'];

    if ($utilisateur == $_GET['id_entreprise']){
        $valeur = 1;
    }
    else {
        $valeur = 0;
    }

    echo $valeur;
    exit;
}
