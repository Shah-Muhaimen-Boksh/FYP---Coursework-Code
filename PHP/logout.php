<?php
    session_start(); // Start a new or resume the existing session
    session_destroy(); // Destroy all data registered to the session
    header("Location: login.php") // Redirect to the login page
?>