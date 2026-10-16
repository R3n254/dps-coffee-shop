<?php
// order.php
include 'auth.php';
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = intval($_GET['id']);
$stmt = mysqli_prepare($conn, "SELECT id, name, price, image_url FROM product WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$product = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$product) {
    die("Product not found!");
}

$is_customer = isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'customer';
$original_price = $product['price'];
$final_price = $is_customer ? $original_price * 0.9 : $original_price;

$order_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - DPS Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Order Summary</h4>
            </div>
            <div class="card-body">
                <?php if ($order_success): ?>
                    <div class="alert alert-success text-center">
                        <h5>Order Placed Successfully! 🎉</h5>
                        <p class="mb-2">Thank you for ordering with DPS Coffee Shop.</p>
                        <a href="index.php" class="btn btn-primary btn-sm mt-2">Back to Menu</a>
                    </div>
                <?php else: ?>
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" class="img-fluid rounded object-fit-cover" alt="coffee">
                        </div>
                        <div class="col-md-8">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <?php if ($is_customer): ?>
                                <p class="mb-1 text-muted">Regular Price: <span class="text-decoration-line-through">Rp <?= number_format($original_price, 0, ',', '.') ?></span></p>
                                <p class="mb-1 text-success fw-bold">Customer Discount (10% OFF): Rp <?= number_format($final_price, 0, ',', '.') ?></p>
                                <span class="badge bg-info text-dark">Logged-in Customer Discount Applied</span>
                            <?php else: ?>
                                <p class="mb-1 fw-bold">Price: Rp <?= number_format($original_price, 0, ',', '.') ?></p>
                                <div class="alert alert-warning py-1 small mt-2">
                                    💡 <strong>Tip:</strong> <a href="login.php">Login</a> as a customer to get an automatic 10% discount on this order!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <form method="POST">
                        <button type="submit" class="btn btn-success w-100 py-2">Confirm & Place Order</button>
                        <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
