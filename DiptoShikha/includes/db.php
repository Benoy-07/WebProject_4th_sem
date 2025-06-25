<?php
$host = 'localhost';
$db = 'diptoshikha_db'; // use your DB name
$user = 'root';
$pass = ''; // default for XAMPP

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
