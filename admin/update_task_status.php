<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized");
}

$task_id = $_POST['task_id'];
$status  = $_POST['status'];

$stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $task_id);
$stmt->execute();

header("Location: view_tasks.php");
exit();
