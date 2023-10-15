<?php
$servername = "localhost";
$username = "root"; // Gantikan dengan username MySQL Anda
$password = ""; // Gantikan dengan password MySQL Anda
$dbname = "test"; // Gantikan dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $from_email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // SQL untuk menyimpan data ke dalam tabel
    $sql = "INSERT INTO messages (email, subject, message) VALUES ('$from_email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Pesan berhasil terkirim dan disimpan di database. Terima kasih!");</script>';
        echo '<script>window.location.href = "index.php";</script>'; // Ganti "index.php" dengan halaman yang Anda inginkan
        exit();
    } else {
        echo '<script>alert("Maaf, pesan tidak dapat terkirim dan disimpan di database.");</script>';
        echo '<script>window.location.href = "index.php";</script>'; // Ganti "index.php" dengan halaman yang Anda inginkan
        exit();
    }
}
