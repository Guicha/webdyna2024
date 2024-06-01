<?php
$database = "webdyna2024";

$Le_mec_qui_est_co = $_SESSION['identifiant_utilisateur'];

$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IDformation'])) {
    $formationId = $_POST['IDformation'];
    $supprimer_projet_de_formation = 'DELETE FROM `projet` WHERE `projet`.`identifiant_formation` ='.$formationId;
    mysqli_query($db_handle, $supprimer_projet_de_formation);

    $supprimer_formation = 'DELETE FROM `formation` WHERE `formation`.`identifiant_formation` ='.$formationId;
    mysqli_query($db_handle, $supprimer_formation);
    }
?>