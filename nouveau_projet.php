<html

    <head>

        <meta http-equiv="refresh" content="0.1;url=profile.php">

    </head>

</html>

<?php
require "verif_session.php";


if (isSet($_POST['newprojet'])) {

    $database = "webdyna2024";

    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);


    $formationId = $_POST['formationID'];
    $nom = str_replace("'","''",$_POST['nom_de_projet']);
    $description = str_replace("'","''",$_POST['description']);
    $date_de_projet = $_POST['date_projet'];

    if($db_found) {
        $sql5 = "INSERT INTO `projet` (`identifiant_projet`, `nom`, `description`, `date`, `identifiant_formation`) VALUES (NULL, '" . $nom . "', '" . $description . "', '" . $date_de_projet ."', '" . $formationId . "')";
        $result5 = mysqli_query($db_handle, $sql5);

        echo "<script>
                    $('#save').click();
        </script>";

    }
}

