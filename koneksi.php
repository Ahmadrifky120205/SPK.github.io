<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pesan"; // Pastikan nama database ini benar

$conn = mysqli_connect($host, $user, $pass, $db);

// Baris ini penting untuk memeriksa koneksi awal
if (!$conn) {
    die("Koneksi gagal dari dalam file koneksi.php: " . mysqli_connect_error());
}
?>