<?php

require "verif_session.php";

include "liaison_bdd.php";

if (isset($_POST['liker'])) {

    $id_post = $_POST['identifiant_post'];
    $id_utilisateur = $_SESSION['identifiant_utilisateur'];

    $sql = "SELECT * FROM likes WHERE identifiant_post=$id_post AND identifiant_utilisateur=$id_utilisateur";
    $result = mysqli_query($conn, $sql);

    $num_rows = mysqli_num_rows($result);


    if ($num_rows == 0) { // L'utilisateur n'a pas deja liké le post

        $sql = "INSERT INTO likes(identifiant_utilisateur, identifiant_post) VALUES (\"$id_utilisateur\",\"$id_post\")";

    } else { // L'utilisateur a deja liké ; on enleve donc son like

        $sql = "DELETE FROM likes WHERE identifiant_post=$id_post AND identifiant_utilisateur=$id_utilisateur";
    }

    $result = mysqli_query($conn, $sql);

    // On revient à la page initiale
    $sql = "SELECT post.identifiant_utilisateur FROM post WHERE post.identifiant_post = $id_post";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_row($result);

    $page_perso = "Location: wall_page.php?user=" . $row['0'];

    header($page_perso);
}

?>