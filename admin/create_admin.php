<?php
include '../config.php'; // pastikan di config.php ada $koneksi

// Data admin
$fullname = "Administrator";
$email    = "admin@usk.ac.id";
$password = password_hash("00555", PASSWORD_DEFAULT); // hash password
$role     = "admin";

// Insert admin dengan prepared statement
$stmt = $conn->prepare(
    "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $fullname, $email, $password, $role);

if ($stmt->execute()) {
    echo "✅ Admin berhasil dibuat!";
} else {
    echo "❌ Gagal: " . $stmt->error;
}
