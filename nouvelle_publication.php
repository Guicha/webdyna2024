<?php

require "verif_session.php";

include "liaison_bdd.php";

if (isset($_POST['publier'])) {

    $timestamp = $_POST['date'];
    $test = $_POST['identifiant_auteur'];

    print_r($timestamp);

    echo "<br>";

    print_r($test);
}

?>