<?php
require_once "../auth.php";
require_role('admin');
require_once "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dept = trim($_POST['department']);
    $dob = $_POST['dob'];
    $joining_date = $_POST['joining_date'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $photoName = null;

    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        $target = "../uploads/" . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    }

    $stmt = $conn->prepare("INSERT INTO users (name,email,password,role,department,dob,joining_date,photo) VALUES (?,?,?,'employee',?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $email, $pass, $dept, $dob, $joining_date, $photoName);
    $stmt->execute();

    header("Location: employees.php");
    exit();
}

include "header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-7 col-lg-6">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white border-0"><h5 class="mb-0">Add Employee</h5></div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-2">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" required>
          </div>

          <div class="mb-2">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>

          <div class="mb-2">
            <label class="form-label">Department</label>
            <input class="form-control" name="department">
          </div>

          <div class="mb-2">
            <label class="form-label">Date of Birth</label>
            <input class="form-control" type="date" name="dob">
          </div>

          <div class="mb-2">
            <label class="form-label">Joining Date</label>
            <input class="form-control" type="date" name="joining_date">
          </div>

          <div class="mb-2">
            <label class="form-label">Photo</label>
            <input class="form-control" type="file" name="photo" accept="image/*">
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="employees.php" class="btn btn-outline-secondary">Cancel</a>
            <button class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div></body></html>