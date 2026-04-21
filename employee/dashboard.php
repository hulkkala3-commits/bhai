<?php
require_once "../auth.php";
require_role('employee');
require_once "../db.php";

$emp_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name,email,department,dob,joining_date,photo FROM users WHERE id=?");
$stmt->bind_param("i", $emp_id);
$stmt->execute();
$emp = $stmt->get_result()->fetch_assoc();

if (!$emp) die("Employee record not found.");

include "header.php";
?>

<div class="row g-3">
  <div class="col-12 col-lg-4">
    <div class="card shadow-sm border-0">
      <div class="card-body text-center">
        <?php if (!empty($emp['photo'])) { ?>
          <img src="../uploads/<?php echo htmlspecialchars($emp['photo']); ?>" width="120" height="120" style="object-fit:cover;border-radius:50%;margin-bottom:15px;">
        <?php } else { ?>
          <div style="width:120px;height:120px;border-radius:50%;background:#ddd;margin:0 auto 15px auto;display:flex;align-items:center;justify-content:center;">
            No Photo
          </div>
        <?php } ?>

        <h4 class="mb-1"><?php echo htmlspecialchars($emp['name']); ?></h4>
        <div class="text-muted"><?php echo htmlspecialchars($emp['email']); ?></div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="mb-3">Employee Information</h5>
        <div class="row">
          <div class="col-md-6 mb-2"><strong>Department:</strong> <?php echo htmlspecialchars($emp['department']); ?></div>
          <div class="col-md-6 mb-2"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($emp['dob']); ?></div>
          <div class="col-md-6 mb-2"><strong>Joining Date:</strong> <?php echo htmlspecialchars($emp['joining_date']); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$stmt = $conn->prepare("SELECT task,status,created_at FROM tasks WHERE employee_id=? ORDER BY id DESC");
$stmt->bind_param("i", $emp_id);
$stmt->execute();
$tasks = $stmt->get_result();
?>

<div class="card shadow-sm border-0 mt-4">
  <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Your Tasks</h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark">
          <tr>
            <th class="ps-3">Task</th>
            <th>Status</th>
            <th>Assigned</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($tasks->num_rows > 0) { ?>
            <?php while($t=$tasks->fetch_assoc()) { ?>
              <tr>
                <td class="ps-3"><?php echo htmlspecialchars($t['task']); ?></td>
                <td>
                  <?php if ($t['status'] === 'Completed') { ?>
                    <span class="badge bg-success">Completed</span>
                  <?php } else { ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                  <?php } ?>
                </td>
                <td class="text-muted"><?php echo htmlspecialchars($t['created_at']); ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="3" class="text-center text-muted py-4">No tasks assigned yet</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div></body></html>