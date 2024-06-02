
<?php
require "verif_session.php";

$database = "webdyna2024";

$utilisateur = $_SESSION['identifiant_utilisateur'];
$sender_name = $_SESSION['prenom'] . ' ' . $_SESSION['nom'];

$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if (isset($_POST['IDemploi'])) {

    $emploi_Id = $_POST['IDemploi'];

    $recherche_id_entreprise = "SELECT identifiant_utilisateur FROM emploi WHERE identifiant_emploi = $emploi_Id ";
    $resultat_id_entreprise = mysqli_query($db_handle, $recherche_id_entreprise);
    $row_id_entreprise = mysqli_fetch_assoc($resultat_id_entreprise);
    $id_entreprise = $row_id_entreprise['identifiant_utilisateur'];

    $recherche_nom_emploi = "SELECT nom FROM emploi WHERE identifiant_emploi = $emploi_Id";
    $resultat_nom_emploi = mysqli_query($db_handle, $recherche_nom_emploi);
    $row_nom_emploi = mysqli_fetch_assoc($resultat_nom_emploi);
    $nom_emploi = $row_nom_emploi['nom'];



    $message = "".$_SESSION['prenom']." ".$_SESSION['nom']." est intéressé(e) par l''offre d''emploi ".$nom_emploi.".";

    $envoi_message = "INSERT INTO `messages` ( `sender_id`, `receiver_id`, `message`, `sender_name`, `last_interaction`) VALUES ('".$utilisateur."', '".$id_entreprise."', '".$message."', 'Système', NOW())";
    mysqli_query($db_handle, $envoi_message);
}

