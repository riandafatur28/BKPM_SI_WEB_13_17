<?php
require('koneksi.php'); // Mengimpor file koneksi.php untuk menghubungkan ke database MySQL

// Cek apakah form di-submit menggunakan tombol 'update'
if (isset($_POST['update'])) {
    // Mengambil data dari form menggunakan metode POST
    $userId = $_POST['txt_id']; // ID user
    $userMail = $_POST['txt_email']; // Email user (readonly)
    $userPass = $_POST['txt_pass']; // Password baru user
    $userName = $_POST['txt_nama']; // Nama lengkap baru user

    // Persiapkan query SQL untuk update data user
    $query = "UPDATE user_detail SET user_password = ?, user_fullname = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query); // Menyiapkan statement SQL

    // Cek apakah statement berhasil dipersiapkan
    if ($stmt) {
        // Mengikat parameter ke dalam statement SQL (password, nama, dan ID user)
        mysqli_stmt_bind_param($stmt, 'ssi', $userPass, $userName, $userId);

        // Menjalankan statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect ke halaman home.php
            header('Location: home.php');
            exit(); // Hentikan eksekusi script setelah redirect
        } else {
            // Jika terjadi kesalahan saat eksekusi statement, tampilkan pesan error
            echo "Error: " . mysqli_error($koneksi);
        }

        // Menutup statement setelah digunakan
        mysqli_stmt_close($stmt);
    } else {
        // Jika terjadi kesalahan saat persiapan statement, tampilkan pesan error
        echo "Error preparing statement: " . mysqli_error($koneksi);
    }
}

// Mendapatkan data user berdasarkan ID untuk ditampilkan di form edit
$id = $_GET['id']; // Mengambil ID user dari URL
$query = "SELECT * FROM user_detail WHERE id = ?"; // Query untuk mendapatkan data user berdasarkan ID
$stmt = mysqli_prepare($koneksi, $query); // Menyiapkan statement SQL

// Cek apakah statement berhasil dipersiapkan
if ($stmt) {
    // Mengikat parameter ID user ke dalam statement SQL
    mysqli_stmt_bind_param($stmt, 'i', $id);
    // Menjalankan statement
    mysqli_stmt_execute($stmt);
    // Mendapatkan hasil query
    $result = mysqli_stmt_get_result($stmt);

    // Jika data user ditemukan, simpan data ke variabel untuk ditampilkan di form
    if ($row = mysqli_fetch_assoc($result)) {
        $userMail = $row['user_email']; // Email user
        $userPass = $row['user_password']; // Password user
        $userName = $row['user_fullname']; // Nama lengkap user
    } else {
        // Jika tidak ada user dengan ID tersebut, tampilkan pesan
        echo "No user found with this ID.";
    }

    // Menutup statement setelah digunakan
    mysqli_stmt_close($stmt);
} else {
    // Jika terjadi kesalahan saat persiapan statement, tampilkan pesan error
    echo "Error preparing statement: " . mysqli_error($koneksi);
}
?>