<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Administrateur - Gestion des utilisateurs</title>
</head>
<body>
<?php
require "verif_session.php";
include "liaison_bdd.php";

// Vérifiez si l'utilisateur est un admin
if ($_SESSION['type'] != 'admin') {
    header('Location: index.php');
    exit();
}

// Ajouter un utilisateur
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $sql = "INSERT INTO utilisateur (type, nom, prenom, email, mdp, photo, bio, cv) VALUES ('user', '$nom', '$prenom', '$email', '$mdp', '', '', '')";
    if (!mysqli_query($conn, $sql)) {
        echo "Erreur: " . mysqli_error($conn);
    }
}

// Supprimer un utilisateur
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];

    // Supprimer les enregistrements associés dans les autres tables
    $sql_likes = "DELETE FROM likes WHERE identifiant_post IN (SELECT identifiant_post FROM post WHERE identifiant_utilisateur = $id)";
    if (!mysqli_query($conn, $sql_likes)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    $sql_commentaire = "DELETE FROM commentaire WHERE identifiant_post IN (SELECT identifiant_post FROM post WHERE identifiant_utilisateur = $id)";
    if (!mysqli_query($conn, $sql_commentaire)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    $sql_post = "DELETE FROM post WHERE identifiant_utilisateur = $id";
    if (!mysqli_query($conn, $sql_post)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    $sql_ami = "DELETE FROM ami WHERE identifiant_utilisateur = $id OR identifiant_ami = $id";
    if (!mysqli_query($conn, $sql_ami)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    $sql_messages_sent = "DELETE FROM messages WHERE sender_id = $id";
    if (!mysqli_query($conn, $sql_messages_sent)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    $sql_messages_received = "DELETE FROM messages WHERE receiver_id = $id";
    if (!mysqli_query($conn, $sql_messages_received)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    $sql_notifications = "DELETE FROM notifications WHERE user_id = $id";
    if (!mysqli_query($conn, $sql_notifications)) {
        echo "Erreur: " . mysqli_error($conn);
    }

    // Supprimer l'utilisateur
    $sql_user = "DELETE FROM utilisateur WHERE identifiant_utilisateur = $id";
    if (!mysqli_query($conn, $sql_user)) {
        echo "Erreur: " . mysqli_error($conn);
    } else {
        header('Location: admin.php');
        exit();
    }
}
?>

<div class="container">
    <!-- Header -->
    <header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="images/logo.png" alt="ECE In Logo" class="img-fluid" style="height: 40px;">
        </a>
        <h1 class="text-center flex-grow-1" style="font-family: 'Montserrat', sans-serif; font-size: 24px; color: #02717A;">Administrateur - Gestion des utilisateurs</h1>
        <div class="text-end">
            <a href="deconnexion.php">
                <button type="button" class="btn btn-outline-primary">Déconnexion</button>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="section">
        <h2>Ajouter un utilisateur</h2>
        <form action="admin.php" method="POST" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                        <label for="nom">Nom</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                        <label for="prenom">Prénom</label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                        <label for="mdp">Mot de passe</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
            </div>
        </form>

        <h2 class="mt-4">Liste des utilisateurs</h2>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-primary">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM utilisateur WHERE identifiant_utilisateur != " . $_SESSION['identifiant_utilisateur'];
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td><a href='admin.php?supprimer=" . $row['identifiant_utilisateur'] . "' class='btn btn-danger'>Supprimer</a></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-3 mt-4 text-muted border-top">
        © 2024 ECE In
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
