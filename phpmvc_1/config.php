<?php

// Konfigurasi database
$server = "localhost"; // Nama atau alamat server database
$user = "root"; // Username untuk mengakses database
$pass = ""; // Password untuk mengakses database
$database = "phpmvc_auth1"; // Nama database yang akan digunakan

// Membuat koneksi ke database
$conn = mysqli_connect($server, $user, $pass, $database);

// Memeriksa apakah koneksi berhasil
if (!$conn) {
    // Jika koneksi gagal, tampilkan pesan JavaScript
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
