<?php

$hostName = "localhost";
$dbUsers = "root";
$dbPassword = "";
$dbName = "register_account";
$database_connection = mysqli_connect($hostName, $dbUsers, $dbPassword, $dbName);

if (!$database_connection) {
    die("Something went wrong;");
}

?>