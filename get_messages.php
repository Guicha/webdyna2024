<?php
session_start();
include 'liaison_bdd.php';

$user_id = $_GET['user_id'];
$current_user_id = $_SESSION['identifiant_utilisateur'];

$query = "SELECT * FROM messages WHERE (sender_id = $current_user_id AND receiver_id = $user_id) OR (sender_id = $user_id AND receiver_id = $current_user_id) ORDER BY date";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $sender = $row['sender_id'] == $current_user_id ? 'Vous' : $row['sender_name'];
    $date = date("d-m-Y H:i", strtotime($row['date'])); // Format de la date
    echo '<p><strong>' . $sender . ' (' . $date . '):</strong> ' . $row['message'] . '</p>';
}

mysqli_close($conn);
?>