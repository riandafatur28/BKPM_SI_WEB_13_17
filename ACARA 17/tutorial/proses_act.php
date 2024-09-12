<?php
include 'koneksi.php'; // Pastikan file koneksi tersedia

// Batas ukuran file maksimal 10 MB
$limit = 10 * 1024 * 1024;

// Ekstensi file yang diperbolehkan
$ekstensi = array('png', 'jpg', 'jpeg', 'gif');

// Jumlah file yang diupload
$jumlahFile = count($_FILES['foto']['name']);

// Loop untuk setiap file yang diupload
for ($x = 0; $x < $jumlahFile; $x++) {
    $namafile = $_FILES['foto']['name'][$x];
    $tmp = $_FILES['foto']['tmp_name'][$x];
    $tipe_file = pathinfo($namafile, PATHINFO_EXTENSION);
    $ukuran = $_FILES['foto']['size'][$x];
    
    // Validasi ukuran file
    if ($ukuran > $limit) {
        header("Location: index.php?alert=gagal_ukuran");
        exit();
    } else {
        // Validasi tipe ekstensi file
        if (!in_array($tipe_file, $ekstensi)) {
            header("Location: index.php?alert=gagal_ektensi");
            exit();
        } else {
            // Beri nama baru untuk menghindari duplikasi nama
            $nama_baru = date('d-m-Y') . '-' . uniqid() . '.' . $tipe_file;
            
            // Pindahkan file yang diupload ke folder 'file'
            move_uploaded_file($tmp, 'file/' . $nama_baru);
            
            // Simpan nama file ke database
            $query = "INSERT INTO gambar (gambar_nama) VALUES ('$nama_baru')";
            mysqli_query($koneksi, $query);
            
            // Redirect jika berhasil
            header("Location: index.php?alert=simpan");
        }
    }
}
?>
