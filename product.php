<?php

function connectToDatabase()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function closeDatabaseConnection($conn)
{
    $conn->close();
}

// Product related functions

function validateImage($image)
{
    $allowed_formats = ['jpg', 'png'];
    $file_size = $image['size'];
    $file_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $max_size = 100 * 1024;

    return in_array(strtolower($file_extension), $allowed_formats) && $file_size <= $max_size;
}

function isProductNameUnique($product_name, $product_id)
{
    $conn = connectToDatabase();
    $check_duplicate_sql = "SELECT id FROM product WHERE product_name = ? AND id <> ?";
    $check_stmt = $conn->prepare($check_duplicate_sql);
    $check_stmt->bind_param("si", $product_name, $product_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    $is_unique = $check_stmt->num_rows === 0;
    $check_stmt->close();
    closeDatabaseConnection($conn);
    return $is_unique;
}

function isNumeric($value)
{
    return is_numeric($value);
}

function countProducts($search_query = '')
{
    $conn = connectToDatabase();

    // Escape special characters in the search query to prevent SQL injection
    $escaped_search_query = mysqli_real_escape_string($conn, $search_query);

    // Construct the SQL query with search condition
    $sql = "SELECT COUNT(*) as total FROM product";
    if (!empty($escaped_search_query)) {
        $sql .= " WHERE product_name LIKE '%$escaped_search_query%'";
    }

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    closeDatabaseConnection($conn);

    return $row['total'];
}

function readProducts($page, $records_per_page, $search_query = "")
{
    $conn = connectToDatabase();

    $start_from = ($page - 1) * $records_per_page;

    if (!empty($search_query)) {
        $escaped_search_query = mysqli_real_escape_string($conn, $search_query);
        $sql = "SELECT * FROM product WHERE product_name LIKE '%$escaped_search_query%' LIMIT $start_from, $records_per_page";
    } else {
        $sql = "SELECT * FROM product LIMIT $start_from, $records_per_page";
    }

    $result = $conn->query($sql);
    $products = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    closeDatabaseConnection($conn);
    return $products;
}


function createProduct($product_name, $product_image, $purchase_price, $selling_price, $stock)
{
    $conn = connectToDatabase();

    if ($product_image['error'] === UPLOAD_ERR_OK && validateImage($product_image)) {
        $file_extension = pathinfo($product_image['name'], PATHINFO_EXTENSION);
        $unique_filename = uniqid() . '.' . $file_extension;
        $upload_directory = 'C:\xampp\htdocs\portfolio\upload\a' . $unique_filename;
        move_uploaded_file($product_image['tmp_name'], $upload_directory);
        $product_image_url = '/portfolio/upload/a' . $unique_filename;
    } else {
        closeDatabaseConnection($conn);
        return false;
    }

    if (!isProductNameUnique($product_name, 0)) {
        closeDatabaseConnection($conn);
        return false;
    }

    if (!isNumeric($purchase_price) || !isNumeric($selling_price) || !isNumeric($stock)) {
        closeDatabaseConnection($conn);
        return false;
    }

    $sql = "INSERT INTO product (product_name, product_image, purchase_price, selling_price, stock)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdds", $product_name, $product_image_url, $purchase_price, $selling_price, $stock);

    $result = $stmt->execute();
    closeDatabaseConnection($conn);

    return $result;
}

function updateProduct($product_id, $product_name, $purchase_price, $selling_price, $stock, $product_image)
{
    $conn = connectToDatabase();

    if ($product_image['error'] === UPLOAD_ERR_OK && validateImage($product_image)) {
        $file_extension = pathinfo($product_image['name'], PATHINFO_EXTENSION);
        $unique_filename = uniqid() . '.' . $file_extension;
        $upload_directory = 'C:\xampp\htdocs\portfolio\upload\a' . $unique_filename;
        move_uploaded_file($product_image['tmp_name'], $upload_directory);
        $product_image_url = '/portfolio/upload/a' . $unique_filename;
    } else {
        closeDatabaseConnection($conn);
        return false;
    }

    if (!isProductNameUnique($product_name, $product_id)) {
        closeDatabaseConnection($conn);
        return false;
    }

    if (!isNumeric($purchase_price) || !isNumeric($selling_price) || !isNumeric($stock)) {
        closeDatabaseConnection($conn);
        return false;
    }

    $sql = "UPDATE product
            SET product_name = ?,
                product_image = ?,
                purchase_price = ?,
                selling_price = ?,
                stock = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssidi", $product_name, $product_image_url, $purchase_price, $selling_price, $stock, $product_id);

    $result = $stmt->execute();
    closeDatabaseConnection($conn);

    return $result;
}

function deleteProduct($product_id)
{
    $conn = connectToDatabase();
    $sql = "DELETE FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $result = $stmt->execute();
    closeDatabaseConnection($conn);
    return $result;
}
