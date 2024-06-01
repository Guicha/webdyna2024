<?php
require "verif_session.php";
include 'liaison_bdd.php';

$current_user_id = $_SESSION['identifiant_utilisateur'];
$user_id = $_POST['user_id'];
$message = $_POST['message'];
$sender_name = $_SESSION['prenom'] . ' ' . $_SESSION['nom'];

$query = "INSERT INTO messages (sender_id, receiver_id, message, sender_name, last_interaction) VALUES ($current_user_id, $user_id, '$message', '$sender_name', NOW())";
mysqli_query($conn, $query);

mysqli_close($conn);
?>
