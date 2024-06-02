<?php

require "verif_session.php";
include "liaison_bdd.php";

if (isset($_POST['publier'])) {
    $titre = $_POST['titre_publication'];
    $localisation = $_POST['localisation_publication'];
    $description = $_POST['description_publication'];
    $prive = $_POST['prive'];
    $identifiant_auteur = $_POST['identifiant_auteur'];

    if (isset($_FILES['media_publication'])) {
        $nomFichier = $_FILES['media_publication']['name'];
        $typeFichier = $_FILES['media_publication']['type'];
        $tailleFichier = $_FILES['media_publication']['size'];
        $tmpFichier = $_FILES['media_publication']['tmp_name'];

        // Vérifiez si le fichier est une image ou une video
        $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png', 'mp4', 'mov', 'aif', 'mkv');
        $extensionFichier = pathinfo($nomFichier, PATHINFO_EXTENSION);
        if (!in_array(strtolower($extensionFichier), $extensionsAutorisees)) {
            print_r("Extension interdite");
            //die();
        }

        // Vérifiez la taille du fichier - 50MB maximum
        $tailleMax = 50 * 1024 * 1024; // 50MB
        if ($tailleFichier > $tailleMax) {
            print_r("Fichier trop volumineux");
            //die();
        }

        $dossier = 'posts/';
        $chemin = $dossier . basename($nomFichier);

        if (!move_uploaded_file($tmpFichier, $chemin)) {
            echo "Erreur : Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
            //die();
        }

        $sql = "INSERT INTO post (titre, description, lieu, date, prive, media, identifiant_utilisateur) VALUES (\"$titre\",\"$description\",\"$localisation\",NOW(), \"$prive\",\"$chemin\",\"$identifiant_auteur\")";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Ajout de la notification pour les amis de l'utilisateur
            $message = "Votre connexion " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . " vient de mettre en ligne une nouvelle publication.";
            $notif_query = "INSERT INTO notifications (user_id, message) 
                            SELECT ami.identifiant_utilisateur, '$message'
                            FROM ami 
                            WHERE ami.identifiant_ami = $identifiant_auteur";
            mysqli_query($conn, $notif_query);

            $page_perso = "Location: wall_page.php?user=" . $_SESSION['identifiant_utilisateur'];
            header($page_perso);
        } else {
            header('Location: network.php');
        }
    } else {
        echo "Veuillez fournir un media pour votre publication";
    }
}

?>
