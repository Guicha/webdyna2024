<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Messagerie - ECE In</title>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
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
            <?php
            echo "<li> <a href='wall_page.php?user=". $_SESSION['identifiant_utilisateur'] . "' class='nav-link px-2 link-dark'>Mon mur</a> </li>";
            ?>
            <li><a href="profile.php" class="nav-link px-2 link-dark">Profil</a></li>
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
                    <a href="https://us05web.zoom.us/j/84397421212?pwd=xR3TkhxHivtbORmoc7lyUlsLbMBXOt.1"><button type="button" class="btn btn-info float-end">Converser sur Zoom</button></a>
                </div>

                <div class="card-body" id="chat-box" style="max-height: 340px; overflow: auto">
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
        © 2024 ECE In <br>
        <small> <i>
                <a href="mailto:contact@ecein.fr">contact@ecein.fr</a> <br>
                01 44 39 06 00 <br>
                10 rue Sextius Michel, Paris 15 <br>
            </i> </small>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        loadUsers();

        $('#send-message').click(function () {
            sendMessage();
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
            }, 1000); // Refresh every 3 seconds
        }
    });
</script>
</body>
</html>
