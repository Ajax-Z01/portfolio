<?php
include_once("C:\\xampp\htdocs\portfolio\product.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Panggil fungsi deleteProduct untuk menghapus produk
    $result = deleteProduct($product_id);

    if ($result) {
        echo "<script>window.location.href='/portfolio/product/';</script>";
        exit();
    } else {
        echo "Failed to delete product.";
    }
} else {
    echo "Invalid request.";
}
