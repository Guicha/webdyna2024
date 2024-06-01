<?php

require "verif_session.php";

include "liaison_bdd.php";

if (isset($_POST['commenter'])) {

    $description = $_POST['description'];
    $id_post = $_POST['identifiant_post'];
    $id_auteur = $_SESSION['identifiant_utilisateur'];

    if (!empty($description)) {

        $sql = "INSERT INTO commentaire(description, identifiant_auteur, date, identifiant_post) VALUES (\"$description\",\"$id_auteur\", NOW(),\"$id_post\")";
        $result = mysqli_query($conn, $sql);

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    } else {

        header('Location: index.php');
    }
}

?>
