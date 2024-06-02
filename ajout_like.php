<?php

require "verif_session.php";
include "liaison_bdd.php";

if (isset($_POST['liker'])) {
    $id_post = $_POST['identifiant_post'];
    $id_utilisateur = $_SESSION['identifiant_utilisateur'];

    // Vérifier si l'utilisateur a déjà liké le post
    $sql = "SELECT * FROM likes WHERE identifiant_post=$id_post AND identifiant_utilisateur=$id_utilisateur";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) { // L'utilisateur n'a pas déjà liké le post
        $sql = "INSERT INTO likes(identifiant_utilisateur, identifiant_post) VALUES (\"$id_utilisateur\",\"$id_post\")";
        $action = "liked"; // Action pour la notification
    } else { // L'utilisateur a déjà liké ; on enlève donc son like
        $sql = "DELETE FROM likes WHERE identifiant_post=$id_post AND identifiant_utilisateur=$id_utilisateur";
        $action = "unliked"; // Action pour la notification
    }

    $result = mysqli_query($conn, $sql);

    if ($action == "liked") {
        // Récupérer l'auteur de la publication
        $sql = "SELECT post.identifiant_utilisateur FROM post WHERE post.identifiant_post = $id_post";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $identifiant_auteur = $row['identifiant_utilisateur'];

        // Ajouter une notification pour l'auteur de la publication
        $message = $_SESSION['prenom'] . " " . $_SESSION['nom'] . " a liké votre publication.";
        $notif_query = "INSERT INTO notifications (user_id, message) VALUES ($identifiant_auteur, '$message')";
        mysqli_query($conn, $notif_query);
    }

    // Rediriger vers la page initiale
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>
