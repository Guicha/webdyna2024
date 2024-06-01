<?php

require "verif_session.php";

include "liaison_bdd.php";

$id_post = $_GET['id_post'];

// Affichage des commentaires du post
$sql_commentaires = "SELECT * FROM commentaire WHERE identifiant_post=$id_post ORDER BY commentaire.date DESC";
$result_commentaires = mysqli_query($conn, $sql_commentaires);

while ($data_commentaires = mysqli_fetch_assoc($result_commentaires)) {

    $id_commentaire = $data_commentaires['identifiant_commentaire'];


    $sql_auteur = "SELECT prenom,nom,identifiant_utilisateur FROM commentaire,utilisateur WHERE commentaire.identifiant_commentaire=$id_commentaire AND commentaire.identifiant_auteur = utilisateur.identifiant_utilisateur";
    $result_auteur = mysqli_query($conn, $sql_auteur);

    $row_auteur = mysqli_fetch_row($result_auteur);

    $auteur_prenom = $row_auteur['0'];
    $auteur_nom = $row_auteur['1'];
    $auteur_identifiant = $row_auteur['2'];

    $page_auteur = "wall_page.php?user=" . $auteur_identifiant;

    echo "<div class='container'>";

    echo "<div class='row'>";

    echo "<h5> <a href=$page_auteur>" . $auteur_prenom . " " . $auteur_nom . "</a> - (Posté le: " . $data_commentaires['date'] . ")</h5>";

    echo "<small> <p>" . $data_commentaires['description'] . "</p> </small>";

    echo "</div>";

    echo "</div>";
}



echo "<div class='modal-footer justify-content-start'>";

echo "<form method='POST' action='ajout_commentaire.php'>";

echo "<div class='row justify-content-between'>";

echo "<input type='hidden' name='identifiant_post' value='$id_post'>";

echo "<div class='col'><input type='text' name='description' class='form-control' placeholder='Donnez votre avis...'></div>";

echo "<div class='col-2'><button type='submit' name='commenter' class='btn btn-primary'>Commenter</button></div>";

echo "</div>";

echo "</form>";

echo "</div>";


?>