<?php
class crud extends koneksi{

// Method untuk melihat data
public function lihatData() {
$sql = "SELECT * FROM user_detail";
$result = $this->koneksi->prepare($sql);
$result->execute();
return $result; // Jangan lupa untuk mengembalikan hasil query
}

// Method untuk insert data
public function insertData($email, $pass, $nama){
try {
// Query untuk memasukkan data ke database
$sql = "INSERT INTO user_detail(user_email, user_password, user_fullname, level) VALUES (:email, :pass, :nama, 2)";
$result = $this->koneksi->prepare($sql);

// Binding parameter
$result->bindParam(':email', $email);
$result->bindParam(':pass', $pass);
$result->bindParam(':nama', $nama);

// Eksekusi query
$result->execute();

return true; // Mengembalikan true jika berhasil
} catch (PDOException $e) {
// Menangkap error dan mengembalikannya jika ada masalah
echo "Error: " . $e->getMessage();
return false;
}
}
}
?>