<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$task_id = $_GET['id'];
$emp_id = $_SESSION['user_id'];

// Update only employee's own task
$conn->query("UPDATE tasks 
              SET status='Completed' 
              WHERE id=$task_id AND employee_id=$emp_id");

header("Location: dashboard.php");
exit;
