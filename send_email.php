<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = "azhar.ala99@gmail.com";

    $from_email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $email_message = "Subject: $subject\n\n$message";

    $headers = "From: $from_email";
    if (mail($to_email, $subject, $email_message, $headers)) {
        echo '<script>alert("Pesan berhasil terkirim. Terima kasih!");</script>';
    } else {
        echo '<script>alert("Maaf, pesan tidak dapat terkirim.");</script>';
    }
}
