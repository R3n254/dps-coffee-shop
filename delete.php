<?php
include 'auth.php';
include 'config.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;
?>
