<?php include 'header.php'; ?>
<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch employees
$employees = $conn->query("SELECT id, name FROM users WHERE role='employee'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $task = $_POST['task'];

    $conn->query("INSERT INTO tasks (employee_id, task, status)
              VALUES ('$employee_id', '$task', 'Pending')");


    echo "<p style='color:green;'>Task assigned successfully</p>";
}
?>


<h3>Assign Task to Employee</h3>

<form method="POST">
    Select Employee:<br>
    <select name="employee_id" required>
        <option value="">-- Select --</option>
        <?php while ($emp = $employees->fetch_assoc()) { ?>
            <option value="<?php echo $emp['id']; ?>">
                <?php echo $emp['name']; ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    Task Description:<br>
    <textarea name="task" required></textarea>
    <br><br>

    <button type="submit">Assign Task</button>
</form>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>
