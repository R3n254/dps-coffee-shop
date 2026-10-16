<?php
// index.php
include 'auth.php';
include 'config.php';

$query = "SELECT id, name, price, image_url FROM product";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPS Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Coffee Menu</h4>
                <?php if (is_admin()): ?>
                    <a href="add_product.php" class="btn btn-light btn-sm fw-bold">+ Add New Product</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="<?= htmlspecialchars($row['image_url']) ?>" width="80" height="80" class="img-thumbnail object-fit-cover" alt="coffee image"></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['name']) ?></td>
                                <td>
                                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'customer'): ?>
                                        <span class="text-muted text-decoration-line-through">Rp <?= number_format($row['price'], 0, ',', '.') ?></span><br/>
                                        <strong class="text-success">Rp <?= number_format($row['price'] * 0.9, 0, ',', '.') ?></strong> 
                                        <span class="badge bg-info text-dark">10% OFF</span>
                                    <?php else: ?>
                                        <strong>Rp <?= number_format($row['price'], 0, ',', '.') ?></strong>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (is_admin()): ?>
                                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</a>
                                    <?php else: ?>
                                        <a href="order.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Order Now</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
