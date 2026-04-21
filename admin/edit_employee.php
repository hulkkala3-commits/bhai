<?php
require_once "../auth.php";
require_role('admin');
require_once "../db.php";

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT name,email,department,dob,joining_date,photo FROM users WHERE id=? AND role='employee'");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) die("Employee not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dept = trim($_POST['department']);
    $dob = $_POST['dob'];
    $joining_date = $_POST['joining_date'];

    $photoName = $user['photo'];

    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        $target = "../uploads/" . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, department=?, dob=?, joining_date=?, photo=? WHERE id=? AND role='employee'");
    $stmt->bind_param("ssssssi", $name, $email, $dept, $dob, $joining_date, $photoName, $id);
    $stmt->execute();

    header("Location: employees.php");
    exit();
}

include "header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-7 col-lg-6">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white border-0"><h5 class="mb-0">Edit Employee</h5></div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-2">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
          </div>

          <div class="mb-2">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          </div>

          <div class="mb-2">
            <label class="form-label">Department</label>
            <input class="form-control" name="department" value="<?php echo htmlspecialchars($user['department']); ?>">
          </div>

          <div class="mb-2">
            <label class="form-label">Date of Birth</label>
            <input class="form-control" type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>">
          </div>

          <div class="mb-2">
            <label class="form-label">Joining Date</label>
            <input class="form-control" type="date" name="joining_date" value="<?php echo htmlspecialchars($user['joining_date']); ?>">
          </div>

          <div class="mb-2">
            <label class="form-label">Current Photo</label><br>
            <?php if (!empty($user['photo'])) { ?>
              <img src="../uploads/<?php echo htmlspecialchars($user['photo']); ?>" width="80" height="80" style="object-fit:cover;border-radius:8px;">
            <?php } else { ?>
              <span class="text-muted">No photo</span>
            <?php } ?>
          </div>

          <div class="mb-3">
            <label class="form-label">Change Photo</label>
            <input class="form-control" type="file" name="photo" accept="image/*">
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="employees.php" class="btn btn-outline-secondary">Cancel</a>
            <button class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div></body></html>