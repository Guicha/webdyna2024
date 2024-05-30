<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Messagerie - ECE In</title>
</head>

<body>

<?php
require "verif_session.php";
?>

<div class="container">
    <!-- Header -->
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="images/logo.png" alt="ECE In Logo" class="img-fluid">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-2 link-secondary">Accueil</a></li>
            <li><a href="network.php" class="nav-link px-2 link-dark">Mon Réseau</a></li>
            <li><a href="profile.php" class="nav-link px-2 link-dark">Vous</a></li>
            <li><a href="notifications.php" class="nav-link px-2 link-dark">Notifications</a></li>
            <li><a href="messaging.html" class="nav-link px-2 link-dark">Messagerie</a></li>
            <li><a href="jobs.php" class="nav-link px-2 link-dark">Emplois</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <a href="deconnexion.php">
                <button type="button" class="btn btn-outline-primary me-2">Deconnexion</button>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="row">
        <!-- Navigation Column -->
        <div class="col-md-3">
            <div class="nav-messages">
                <!-- Liste des derniers messages à mettre ici -->
                <?php
                echo "<p>Bienvenue " . $_SESSION['prenom'] . " !</p>";
                ?>
                <ul class="list-group">
                    <!-- Exemple de message -->
                    <li class="list-group-item">Dernier message 1</li>
                    <li class="list-group-item">Dernier message 2</li>
                    <!-- Ajoutez d'autres messages ici -->
                </ul>
            </div>
        </div>

        <!-- Messaging Column -->
        <div class="col-md-9">
            <div class="section">
                <h1>Messagerie</h1>
                <div class="card">
                    <div class="card-header">
                        Conversation avec Nom de la Personne
                    </div>
                    <div class="card-body">
                        <div id="chat-box" class="chat-box">
                            <!-- Afficher les messages ici -->
                            <?php
                            if (file_exists("log.html")) {
                                $contents = file_get_contents("log.html");
                                echo $contents;
                            }
                            ?>
                        </div>
                        <div class="input-group mt-3">
                            <input id="message" type="text" class="form-control" placeholder="Écrire un message...">
                            <div class="input-group-append">
                                <button id="send-btn" class="btn btn-primary" type="button">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-3 mt-4 text-muted border-top">
        © 2024 ECE In
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // Fonction pour envoyer un message
        function sendMessage() {
            var text = $("#message").val();
            if(text != ""){
                $.post("post_message.php", {text: text}, function(data){
                    $("#chat-box").append(data);
                    $("#message").val("");
                });
            }
        }

        // Envoi du message au clic sur le bouton
        $("#send-btn").click(function(){
            sendMessage();
        });

        // Envoi du message à la pression de la touche Entrée
        $("#message").keypress(function(event) {
            if(event.which == 13) {  // 13 est le code ASCII pour la touche Entrée
                sendMessage();
            }
        });

        // Fonction pour rafraîchir la boîte de chat
        function loadChat(){
            $.ajax({
                url: "log.html",
                cache: false,
                success: function(html){
                    $("#chat-box").html(html);
                }
            });
        }

        // Rafraîchir la boîte de chat toutes les secondes
        setInterval(loadChat, 1000);
    });
</script>
</body>
</html>
