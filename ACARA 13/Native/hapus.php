<?php
require('koneksi.php'); // Mengimpor file koneksi.php untuk menghubungkan ke database MySQL

// Mengambil ID user dari parameter URL
$id = $_GET['id'];

// Menyiapkan query SQL untuk menghapus data user berdasarkan ID
$query = "DELETE FROM user_detail WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query); // Menyiapkan statement SQL

// Cek apakah statement berhasil dipersiapkan
if ($stmt) {
    // Mengikat parameter ID user ke dalam statement SQL
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Menjalankan statement
    mysqli_stmt_execute($stmt);

    // Mengecek apakah ada baris yang terpengaruh (user terhapus)
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Jika user berhasil dihapus, redirect ke halaman home.php
        header("Location: home.php");
        exit(); // Menghentikan eksekusi setelah redirect
    } else {
        // Jika tidak ada user dengan ID yang diberikan, tampilkan pesan
        echo "No user found with this ID.";
    }

    // Menutup statement setelah digunakan
    mysqli_stmt_close($stmt);
} else {
    // Jika terjadi kesalahan saat persiapan statement, tampilkan pesan error
    echo "Error preparing statement: " . mysqli_error($koneksi);
}
?>