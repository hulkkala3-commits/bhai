<?php
session_start();
require_once "db.php";

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email=? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows === 1) {
    $u = $res->fetch_assoc();

    if (password_verify($password, $u['password'])) {
        $_SESSION['user_id'] = (int)$u['id'];
        $_SESSION['role']    = $u['role'];
        $_SESSION['name']    = $u['name'];

        // Attendance only for employees
        if ($u['role'] === 'employee') {
            $today = date("Y-m-d");
            $timeNow = date("H:i:s");

            $check = $conn->prepare("SELECT id FROM attendance WHERE employee_id=? AND login_date=? LIMIT 1");
            $check->bind_param("is", $u['id'], $today);
            $check->execute();
            $checkRes = $check->get_result();

            if ($checkRes->num_rows === 0) {
                $insert = $conn->prepare("INSERT INTO attendance (employee_id, login_date, login_time, status) VALUES (?, ?, ?, 'Present')");
                $insert->bind_param("iss", $u['id'], $today, $timeNow);
                $insert->execute();
            }
        }

        if ($u['role'] === 'admin') {
            header("Location: /employee_management/admin/dashboard.php");
        } else {
            header("Location: /employee_management/employee/dashboard.php");
        }
        exit();
    }
}

header("Location: /employee_management/login.php?error=1");
exit();