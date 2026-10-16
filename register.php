<?php
session_start();
include 'config.php';

// Jika sudah login, lempar ke halaman utama
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = 'customer'; // Default role untuk registrasi baru

    if (empty($username) || empty($password)) {
        $error = "Semua kolom harus diisi!";
    } else {
        // Cek apakah username sudah dipakai
        $check_stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $error = "Username sudah terdaftar! Gunakan username lain.";
        } else {
            // Hash password agar aman
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $role);

            if (mysqli_stmt_execute($stmt)) {
                // Berhasil daftar, redirect ke login
                header("Location: login.php?registered=success");
                exit;
            } else {
                $error = "Gagal mendaftar, silakan coba lagi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - DPS Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm style-card" style="width: 100%; max-width: 400px;">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0 fs-5 fw-bold">Register DPS Coffee Shop</h4>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 mb-3"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Daftar</button>
            </form>

            <div class="mt-3 text-center">
                <p class="mb-0 text-muted">Sudah punya akun? <a href="login.php" class="text-primary text-decoration-none fw-semibold">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
