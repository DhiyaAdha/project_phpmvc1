<?php

// Memasukkan file konfigurasi database
include 'config.php';

// Menonaktifkan laporan error
error_reporting(0);

// Memulai sesi
session_start();

// Memeriksa apakah pengguna telah masuk (sudah memiliki sesi)
if (isset($_SESSION['username'])) {
    // Jika sudah masuk, redirect pengguna ke halaman berhasil_login.php
    header("Location: berhasil_login.php");
}

// Memeriksa apakah tombol submit telah ditekan
if (isset($_POST['submit'])) {
    // Mengambil nilai email dan password yang dikirimkan melalui metode POST
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Mengenkripsi password menggunakan fungsi md5()

    // Membuat query SQL untuk mencari pengguna dengan email dan password yang sesuai
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";

    // Menjalankan query SQL
    $result = mysqli_query($conn, $sql);

    // Memeriksa apakah query mengembalikan setidaknya satu baris data
    if ($result->num_rows > 0) {
        // Jika ada hasil, ambil data baris pertama
        $row = mysqli_fetch_assoc($result);

        // Menyimpan username pengguna dalam sesi
        $_SESSION['username'] = $row['username'];

        // Redirect pengguna ke halaman berhasil_login.php
        header("Location: berhasil_login.php");
    } else {
        // Jika tidak ada hasil, tampilkan pesan kesalahan menggunakan JavaScript
        echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>Niagahoster Tutorial</title>
</head>

<body>
    <div class="alert alert-warning" role="alert">
        <?php echo $_SESSION['error'] ?>
    </div>

    <div class="container">
        
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>
            <p class="login-register-text">Anda belum punya akun? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>

</html>