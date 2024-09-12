<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi ke database
require('koneksi.php');

// Memulai session untuk melacak user login
session_start();

// Mengecek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    // Mengambil input email dan password dari form
    $email = $_POST['txt_email'];
    $pass = $_POST['txt_pass'];

    // Mengecek apakah email dan password tidak kosong setelah di-trim
    if (!empty(trim($email)) && !empty(trim($pass))) {
        
        // Menyiapkan pernyataan SQL untuk mencari user berdasarkan email
        $query = "SELECT * FROM user_detail WHERE user_email = ?";
        $stmt = mysqli_prepare($koneksi, $query);

        // Mengikat parameter (email) dan mengeksekusi query
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Mendeklarasikan variabel untuk menyimpan hasil
        $userVal = $pasVal = $username = $level = '';

        // Mengecek apakah ada data yang ditemukan
        if ($row = mysqli_fetch_assoc($result)) {
            // Mengambil data user yang cocok dari database
            $id = $row['id'];
            $userVal = $row['user_email'];
            $pasVal = $row['user_password'];
            $username = $row['user_fullname'];
            $level = $row['level'];
        }

        // Memverifikasi kecocokan email dan password
        if ($userVal == $email && $pasVal == $pass) {
            // Jika cocok, redirect ke halaman home
            header('Location: home.php');
            exit();
        } else {
            // Jika tidak cocok, menampilkan pesan error dan redirect ke halaman login
            $error = 'User atau password salah!!';
            header('Location: login.php?error=' . urlencode($error));
            exit();
        }
        
    } else {
        // Jika email atau password kosong, menampilkan pesan error
        $error = 'Data Tidak Boleh Kosong';
        echo $error;
    }
}
?>