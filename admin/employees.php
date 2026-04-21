<?php
require_once "../auth.php";
require_role('admin');
require_once "../db.php";
include "header.php";

$res = $conn->query("SELECT id,name,email,department,dob,joining_date,photo FROM users WHERE role='employee' ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Employees</h4>
  <a href="employee_add.php" class="btn btn-primary btn-sm">Add Employee</a>
</div>

<div class="card shadow-sm border-0">
  <div class="table-responsive">
    <table class="table table-hover mb-0 align-middle">
      <thead class="table-dark">
        <tr>
          <th class="ps-3">Photo</th>
          <th>Name</th>
          <th>Email</th>
          <th>Department</th>
          <th>DOB</th>
          <th>Joining Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php while($row=$res->fetch_assoc()) { ?>
        <tr>
          <td class="ps-3">
            <?php if (!empty($row['photo'])) { ?>
              <img src="../uploads/<?php echo htmlspecialchars($row['photo']); ?>" width="55" height="55" style="object-fit:cover;border-radius:50%;">
            <?php } else { ?>
              <span class="text-muted">No photo</span>
            <?php } ?>
          </td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td><?php echo htmlspecialchars($row['department']); ?></td>
          <td><?php echo htmlspecialchars($row['dob']); ?></td>
          <td><?php echo htmlspecialchars($row['joining_date']); ?></td>
          <td>
            <a class="btn btn-outline-warning btn-sm" href="employee_edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a class="btn btn-outline-danger btn-sm"
               href="employee_delete.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Delete this employee?');">Delete</a>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</div></body></html>