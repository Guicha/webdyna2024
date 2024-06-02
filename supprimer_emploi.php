<?php

require "verif_session.php";

$database = "webdyna2024";

$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if (isset($_POST['Id_emploi'])) {

    $emploiId = $_POST['Id_emploi'];
    $supprimer_emploi = "DELETE FROM emploi WHERE identifiant_emploi = $emploiId";
    print_r($supprimer_emploi);

    mysqli_query($db_handle, $supprimer_emploi);
}