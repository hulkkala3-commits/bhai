<?php
$host = "localhost";
$user = "root";
$pass = "admin";   // VERY IMPORTANT: empty for WAMP
$db   = "employee_management";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
