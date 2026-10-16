<?php // navbar.php ?>
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">☕ DPS Coffee Shop</a>
        <div class="d-flex align-items-center gap-2">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="users.php" class="btn btn-outline-light btn-sm">Users</a>
                <a href="add_product.php" class="btn btn-success btn-sm">Add Product</a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-white small me-2">
                    <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars($_SESSION['role'] ?? '') ?></span>
                </span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
                <a href="register.php" class="btn btn-light btn-sm">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
