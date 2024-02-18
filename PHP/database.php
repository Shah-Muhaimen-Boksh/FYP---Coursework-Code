<?php

$hostName = "localhost"; // Database server address
$dbUsers = "root";  // Database username
$dbPassword = ""; // Database password
$dbName = "portfolio_creator"; // Database name
$database_connection = mysqli_connect($hostName, $dbUsers, $dbPassword, $dbName); // Establish database connection

// Check if connection was successful
if (!$database_connection) {
    die("Something went wrong;"); // Terminate script and display error message if connection fails
}

?>