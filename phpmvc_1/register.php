    <?php
    // Memasukkan file konfigurasi database
    include 'config.php';

    // Memulai sesi
    session_start();

    // Memeriksa apakah pengguna telah masuk (sudah memiliki sesi)
    if (isset($_SESSION['username'])) {
        // Jika sudah masuk, redirect pengguna ke halaman index.php
        header("Location: index.php");
        exit(); // Menghentikan eksekusi script setelah melakukan redirect
    }

    // Mendefinisikan variabel untuk menyimpan data input
    $username = $email = $password = $cpassword = '';

    // Memeriksa apakah tombol submit telah ditekan
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Mengambil nilai username, email, password, dan konfirmasi password yang dikirimkan melalui metode POST
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Password yang dimasukkan oleh pengguna saat registrasi
        $cpassword = $_POST['cpassword']; // Konfirmasi password yang dimasukkan oleh pengguna saat registrasi

        // Memeriksa apakah password dan konfirmasi password sesuai
        if ($password === $cpassword) {
            // Meng-hash password menggunakan algoritma bcrypt
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Membuat query SQL untuk memeriksa apakah email sudah terdaftar
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            // Memeriksa apakah query mengembalikan setidaknya satu baris data
            if (mysqli_num_rows($result) > 0) {
                // Jika email sudah terdaftar, tampilkan pesan kesalahan
                echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
            } else {
                // Jika email belum terdaftar, melakukan query INSERT untuk menambahkan pengguna baru ke database
                $sql = "INSERT INTO users (username, email, password)
                        VALUES ('$username', '$email', '$hashedPassword')";
                $result = mysqli_query($conn, $sql);

                // Memeriksa apakah query INSERT berhasil
                if ($result) {
                    // Jika berhasil, tampilkan pesan sukses dan reset nilai variabel
                    echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                    $username = "";
                    $email = "";
                    $password = "";
                    $cpassword = "";
                } else {
                    // Jika terjadi kesalahan saat query INSERT, tampilkan pesan kesalahan
                    echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
                }
            }
        } else {
            // Jika password dan konfirmasi password tidak sesuai, tampilkan pesan kesalahan
            echo "<script>alert('Password Tidak Sesuai')</script>";
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

        <style>
            .input-group input:hover:invalid {
                border: 1px solid red;
            }

            .input-group input:focus:invalid {
                outline: none;
            }

            .input-group input:hover:invalid::after {
                content: 'Anda belum mengisi!';
                color: red;
                font-size: 0.8rem;
            }
        </style>

        <title>Niagahoster Register</title>
    </head>

    <body>
        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
                <div class="input-group">
                    <input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" value="" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Confirm Password" name="cpassword" value="" required>
                </div>
                <div class="input-group">
                    <button type="submit" name="submit" class="btn">Register</button>
                </div>
                <p class="login-register-text">Anda sudah punya akun? <a href="index.php">Login</a></p>
            </form>
        </div>

        <!-- hapus aja dulu -->
        
    </body>

    </html>