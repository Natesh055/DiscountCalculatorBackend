<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "myproj";

// connecting to database
$conn = mysqli_connect($server, $username, $password, $database);

// agar connection nahi hai to terminate
if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>
