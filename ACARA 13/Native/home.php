<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi ke database
require("koneksi.php");

// Mengambil input dari URL (parameter GET) dan membersihkannya menggunakan htmlspecialchars() 
// untuk mencegah serangan Cross-Site Scripting (XSS). 
// Jika parameter tidak ada, nilai default adalah string kosong.
$email = isset($_GET['user_fullname']) ? htmlspecialchars($_GET['user_fullname']) : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata halaman dan impor CSS Bootstrap untuk tampilan yang responsif dan rapi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <!-- Menampilkan pesan selamat datang dengan nama pengguna yang diambil dari parameter URL -->
        <h1 class="mb-4">Selamat Datang <?php echo $email; ?></h1>

        <!-- Tabel untuk menampilkan daftar pengguna dari database -->
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th> <!-- Kolom untuk nomor urut -->
                    <th>Email</th> <!-- Kolom untuk menampilkan email pengguna -->
                    <th>Nama</th> <!-- Kolom untuk menampilkan nama pengguna -->
                    <th>Actions</th> <!-- Kolom untuk tombol tindakan edit dan hapus -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil seluruh data dari tabel user_detail di database
                $query = "SELECT * FROM user_detail";
                $result = mysqli_query($koneksi, $query); // Eksekusi query ke database
                
                // Jika query berhasil dijalankan
                if ($result) {
                    $no = 1; // Inisialisasi nomor urut
                    // Looping melalui hasil query untuk setiap pengguna
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Membersihkan data yang diambil dari database untuk menghindari XSS
                        $userMail = htmlspecialchars($row['user_email']);
                        $userName = htmlspecialchars($row['user_fullname']);
                        ?>

                <tr>
                    <!-- Menampilkan data pengguna ke dalam tabel -->
                    <td><?php echo $no; ?></td> <!-- Menampilkan nomor urut -->
                    <td><?php echo $userMail; ?></td> <!-- Menampilkan email pengguna -->
                    <td><?php echo $userName; ?></td> <!-- Menampilkan nama pengguna -->
                    <td>
                        <!-- Tombol untuk mengedit dan menghapus data pengguna berdasarkan ID -->
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php
                        $no++; // Increment nomor urut untuk baris berikutnya
                    }
                } 
                ?>
            </tbody>
        </table>
    </div>

    <!-- Mengimpor JavaScript Bootstrap dan dependensinya untuk mendukung interaktivitas halaman -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>