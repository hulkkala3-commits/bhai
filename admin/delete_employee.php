<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$conn->query("DELETE FROM users WHERE id=$id AND role='employee'");

header("Location: dashboard.php");
exit;
