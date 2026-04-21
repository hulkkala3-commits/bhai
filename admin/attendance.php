<?php
require_once "../auth.php";
require_role('admin');
require_once "../db.php";
include "header.php";

$today = date("Y-m-d");

$sql = "
SELECT users.name, users.email, users.department, attendance.login_time, attendance.status
FROM attendance
JOIN users ON attendance.employee_id = users.id
WHERE attendance.login_date = ?
ORDER BY attendance.login_time ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Today's Attendance</h4>
    <span class="badge bg-primary"><?php echo $today; ?></span>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr>
                    <th class="ps-3">Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Login Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($res->num_rows > 0) { ?>
                    <?php while ($row = $res->fetch_assoc()) { ?>
                        <tr>
                            <td class="ps-3"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><?php echo htmlspecialchars($row['login_time']); ?></td>
                            <td><span class="badge bg-success"><?php echo htmlspecialchars($row['status']); ?></span></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No employee logged in today</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</body>
</html>