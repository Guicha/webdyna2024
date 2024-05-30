<?php

session_start();

if (empty($_SESSION)) {
    header('Location: login.html');
}

?>
