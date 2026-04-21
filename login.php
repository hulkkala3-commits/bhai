<?php
session_start();

if (isset($_SESSION['user_id'], $_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: /employee_management/admin/dashboard.php");
    } else {
        header("Location: /employee_management/employee/dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Management Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: -1;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.35);
            color: white;
            animation: fadeInUp 0.7s ease;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 24px;
            font-weight: 700;
        }

        .form-label {
            color: #fff;
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: none;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
        }

        .btn-login {
            width: 100%;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(13,110,253,0.35);
        }

        .small-note {
            text-align: center;
            color: #f1f1f1;
            margin-top: 15px;
            font-size: 13px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<video autoplay muted loop class="video-bg">
    <source src="assets/video/login-bg.mp4" type="video/mp4">
</video>

<div class="overlay"></div>

<div class="login-wrapper">
    <div class="login-card">
        <h2>Employee Management Login</h2>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger">Invalid email or password</div>
        <?php } ?>

        <form method="POST" action="login_action.php">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>

        <div class="small-note">
            Admin and employees can log in here
        </div>
    </div>
</div>

</body>
</html>