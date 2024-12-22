<?php

// Menampilkan kesalahan untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Debugging: Tampilkan input mentah
$rawData = file_get_contents("php://input");
error_log("Raw data received: " . $rawData); // Ini akan menulis ke log kesalahan

// Mengatur header untuk menerima permintaan JSON
header('Content-Type: application/json');

// Mengambil data JSON dari permintaan
$data = json_decode($rawData);

// Memeriksa apakah data JSON berhasil didekode
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input.']);
    exit();
}

// Mengambil nilai dari data yang diterima
$fullname = htmlspecialchars($data->fullname);
$phonenumber = htmlspecialchars($data->phonenumber);
$destination = htmlspecialchars($data->destination);
$rating = (int)$data->rating; // Cast to integer for validation
$feedback = htmlspecialchars($data->feedback);

// Validasi input
if (empty($fullname) || empty($phonenumber) || empty($destination) || empty($feedback) || $rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit();
}

// Detail koneksi ke database
$servername = "localhost"; // Nama server
$username = "root";        // Nama pengguna (default: root)
$password = "";            // Password (default: kosong untuk XAMPP)
$dbname = "feedback_db";   // Nama database yang telah Anda buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Menyiapkan dan mengikat pernyataan
$stmt = $conn->prepare("INSERT INTO feedback (fullname, phonenumber, destination, rating, feedback) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param("sssis", $fullname, $phonenumber, $destination, $rating, $feedback);

// Menjalankan pernyataan
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Feedback saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

// Menutup pernyataan dan koneksi
$stmt->close();
$conn->close();
?>