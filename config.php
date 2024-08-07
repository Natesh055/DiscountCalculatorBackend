<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "myproj";

// Create a connection
$conn = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>
