<?php
$database = "webdyna2024";


$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IDprojet'])) {
    $projetId = $_POST['IDprojet'];

    $sql = 'DELETE FROM `projet` WHERE `projet`.`identifiant_projet` ='.$projetId;
    mysqli_query($db_handle, $sql);
}
?>