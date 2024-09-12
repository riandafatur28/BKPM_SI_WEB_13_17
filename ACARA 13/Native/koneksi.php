<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "users";

// Membuat koneksi ke database
$koneksi = mysqli_connect($server, $username, $password, $db);

// Mengecek apakah koneksi berhasil
// if(mysqli_connect_errno()){
//     echo "Koneksi gagal : " . mysqli_connect_error();
// } else {
//     echo "Koneksi berhasil!";
// }

?>