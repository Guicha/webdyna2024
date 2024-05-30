<?php

session_start();

require "verif_session.php";

session_destroy();

header('Location: index.php');

?>
