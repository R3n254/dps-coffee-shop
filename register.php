<?php
// register.php
include 'auth.php';
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
    
    if (mysqli_stmt_execute($stmt)) {
        $success = "Registration successful! You can now <a href='login.php'>Login</a>.";
    } else {
        $error = "Username already taken or database error.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - DPS Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center"><h4>Register</h4></div>
            <div class="card-body">
                <?php if ($error): ?><div class="alert alert-danger py-2"><?= $error ?></div><?php endif; ?>
                <?php if ($success): ?><div class="alert alert-success py-2"><?= $success ?></div><?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="role" value="customer" required readonly>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Register</button>
                    <br/>
                    <a href="login.php" class="btn btn-outline-dark mt-2 w-100">Back to Login</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
