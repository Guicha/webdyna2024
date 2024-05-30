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
            <li><a href="messaging.php" class="nav-link px-2 link-dark">Messagerie</a></li>
            <li><a href="jobs.php" class="nav-link px-2 link-dark">Emplois</a></li>
        </ul>
        <div class="col-md-3 text-end">
            <a href="deconnexion.php">
                <button type="button" class="btn btn-outline-primary me-2">Déconnexion</button>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="row">
        <div class="col-md-4">
            <h2>Utilisateurs</h2>
            <ul class="list-group" id="user-list">
                <!-- Liste des utilisateurs sera chargée ici -->
            </ul>
        </div>
        <div class="col-md-8">
            <h1>Messagerie</h1>
            <div class="card">
                <div class="card-header" id="chat-header">
                    Conversation avec <span id="chat-with">...</span>
                </div>
                <div class="card-body" id="chat-box">
                    <!-- Afficher les messages ici -->
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" id="message-input" placeholder="Écrire un message...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="send-message" type="button">Envoyer</button>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        loadUsers();

        $('#send-message').click(function () {
            sendMessage();
        });

        // Gérer l'appui sur la touche "Entrée"
        $('#message-input').keypress(function(event) {
            // Vérifier si la touche appuyée est la touche "Entrée" (keyCode 13)
            if (event.which == 13) {
                // Empêcher le comportement par défaut du formulaire
                event.preventDefault();
                // Envoyer le message
                sendMessage();
            }
        });

        function loadUsers() {
            $.ajax({
                url: 'get_users.php',
                method: 'GET',
                success: function (response) {
                    $('#user-list').html(response);
                    $('.user-item').click(function () {
                        var userId = $(this).data('id');
                        var userName = $(this).text();
                        $('#chat-with').text(userName);
                        $('.user-item').removeClass('active');
                        $(this).addClass('active');
                        loadMessages(userId);
                        startAutoRefresh(userId);
                    });
                }
            });
        }

        function loadMessages(userId) {
            $.ajax({
                url: 'get_messages.php',
                method: 'GET',
                data: { user_id: userId },
                success: function (response) {
                    $('#chat-box').html(response);
                }
            });
        }

        function sendMessage() {
            var message = $('#message-input').val();
            var userId = $('.user-item.active').data('id');
            if (message && userId) {
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: { message: message, user_id: userId },
                    success: function () {
                        $('#message-input').val('');
                        loadMessages(userId);
                    }
                });
            }
        }

        function startAutoRefresh(userId) {
            if (window.messageInterval) {
                clearInterval(window.messageInterval);
            }
            window.messageInterval = setInterval(function() {
                loadMessages(userId);
            }, 1000); // Rafraîchir toutes les 3 secondes
        }
    });
</script>
</body>
</html>
