<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$result = $conn->query("
    SELECT tasks.id, tasks.task, tasks.status, users.name
    FROM tasks
    JOIN users ON tasks.employee_id = users.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>All Employee Tasks</h3>

<table class="table table-bordered">
    <tr>
        <th>Employee</th>
        <th>Task</th>
        <th>Status</th>
        <th>Update</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['task'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <form method="POST" action="update_task_status.php">
                <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                <select name="status" class="form-select form-select-sm">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
                <button class="btn btn-success btn-sm mt-1">Update</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>