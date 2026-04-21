
<!DOCTYPE html>
<?php include 'header.php'; ?>

    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container-fluid">
        <span class="navbar-brand">Employee Management</span>
        <div>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="assign_task.php" class="btn btn-outline-light btn-sm">Assign Task</a>
            <a href="view_tasks.php" class="btn btn-outline-light btn-sm">View Tasks</a>
            <a class="btn btn-outline-light btn-sm" href="attendance.php">Attendance</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$result = $conn->query("SELECT * FROM users WHERE role='employee'");
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<h2>Admin Dashboard</h2>

<p>Total Employees: <?php echo $result->num_rows; ?></p>

<a href="add_employee.php">Add Employee</a>

<hr>

<h3>Employee List</h3>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $result = $conn->query("SELECT * FROM users WHERE role='employee'");
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td>
                <a class="btn btn-warning btn-sm" 
                   href="edit_employee.php?id=<?php echo $row['id']; ?>">
                   Edit
                </a>

                <a class="btn btn-danger btn-sm"
                   href="delete_employee.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this employee?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>  <!-- end container -->
</body>
</html>
