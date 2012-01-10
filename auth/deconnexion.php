<?php
    if (isset($_SESSION["type"])) {
        session_destroy();
        header('Location: accueil.htm');
    }
?>
