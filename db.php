<?php
$host = "localhost";       // Host database (biasanya localhost)
$user = "root";            // Username database (default XAMPP = root)
$password = "";            // Password database (default XAMPP = kosong)
$database = "users";  // Nama database sesuai dengan yang kamu buat di phpMyAdmin

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
