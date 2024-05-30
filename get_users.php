<?php
session_start();
include 'liaison_bdd.php';

$current_user_id = $_SESSION['identifiant_utilisateur'];

$query = "
    SELECT U.identifiant_utilisateur, U.prenom, U.nom, MAX(M.last_interaction) AS last_interaction
    FROM Utilisateur U
    LEFT JOIN messages M ON (
        (M.sender_id = U.identifiant_utilisateur AND M.receiver_id = $current_user_id) OR
        (M.receiver_id = U.identifiant_utilisateur AND M.sender_id = $current_user_id)
    )
    WHERE U.identifiant_utilisateur != $current_user_id
    GROUP BY U.identifiant_utilisateur, U.prenom, U.nom
    ORDER BY last_interaction DESC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<li class="list-group-item user-item" data-id="' . $row['identifiant_utilisateur'] . '">' . $row['prenom'] . ' ' . $row['nom'] . '</li>';
}

mysqli_close($conn);
?>
