<?php
session_start();
if(isset($_SESSION['prenom'])){
    if(isset($_POST['text'])){
        $text = $_POST['text'];
        $text_message = "<div class='msgln'><span class='chat-time'>" . date("g:i A") . "</span> <b class='username'>" . $_SESSION['prenom'] . "</b>: " . htmlspecialchars($text) . "<br></div>";
        $myfile = fopen("log.html", "a") or die("Impossible d'ouvrir le fichier log.html");
        fwrite($myfile, $text_message);
        fclose($myfile);
        echo $text_message;
    }
}
?>
