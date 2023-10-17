<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $sql = "INSERT INTO messages (email, subject, message) VALUES ('$from_email', '$subject', '$message')";

    if ($conn->query($sql) === true) {
        echo '<script>alert("Pesan berhasil terkirim dan disimpan di database. Terima kasih!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    } else {
        echo '<script>alert("Maaf, pesan tidak dapat terkirim dan disimpan di database.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }
}
