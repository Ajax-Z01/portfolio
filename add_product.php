<?php
include_once("C:\\xampp\htdocs\portfolio\product.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $purchase_price = $_POST['purchase_price'];
    $selling_price = $_POST['selling_price'];
    $stock = $_POST['stock'];

    $result = createProduct($product_name, $_FILES['product_image'], $purchase_price, $selling_price, $stock);

    if ($result) {
        echo "<script>window.location.href='/portfolio/product/';</script>";
        exit();
    } else {
        echo "Failed to create product.";
    }
}
