<?php
// Detail koneksi
$servername = "localhost"; // Nama server
$username = "root";        // Nama pengguna (default: root)
$password = "";            // Password (default: kosong untuk XAMPP)
$dbname = "feedback_db";   // Nama database yang telah Anda buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>