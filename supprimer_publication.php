<?php

require "verif_session.php";

include "liaison_bdd.php";

if (isset($_POST['supprimer'])) {

    $id_post = $_POST['identifiant_post'];

    print_r($id_post);

    // On supprime les commentaires du post
    $sql = "DELETE FROM commentaire WHERE identifiant_post=$id_post";
    $result = mysqli_query($conn, $sql);

    // On supprimer les likes du post
    $sql = "DELETE FROM likes WHERE identifiant_post=$id_post";
    $result = mysqli_query($conn, $sql);

    // On supprime le post
    $sql = "DELETE FROM post WHERE identifiant_post=$id_post";
    $result = mysqli_query($conn, $sql);

    $page_perso = "Location: wall_page.php?user=" . $_SESSION['identifiant_utilisateur'];

    if ($result) {

        header($page_perso);

    } else {

        header('Location: index.php');
    }




}

?>