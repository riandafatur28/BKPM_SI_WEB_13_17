<?php
session_start(); // Mulai session

require ('koneksi.php'); 
require ('query.php'); 

// Jika session 'user_fullname' ada, simpan ke variabel $fullname, jika tidak redirect ke halaman login
if (isset($_SESSION['user_fullname'])) {
    $fullname = $_SESSION['user_fullname'];
} else {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit;
}

$obj = new crud; // Pastikan class crud sudah tersedia dan bisa diakses
?>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <h1>Selamat Datang <?php echo htmlspecialchars($fullname);?></h1>
    <table border='1'>
        <tr>
            <td>No</td>
            <td>Email</td>
            <td>Nama</td>
            <td>Aksi</td>
        </tr>
        <?php
        // Ambil data dari objek $obj
        $data = $obj->lihatData(); // Pastikan function lihatData mengembalikan data dengan benar
        $no = 1;

        if($data->rowCount() > 0){
            // Tampilkan data user
            while($row = $data->fetch(PDO::FETCH_ASSOC)){
        ?>
        <tr>
            <td><?php echo $no;?></td>
            <td><?php echo htmlspecialchars($row['user_email']); ?></td>
            <td><?php echo htmlspecialchars($row['user_fullname']); ?></td>
            <td>
                <!-- Tanda kutip ditutup dengan benar -->
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="hapus.php?id=<?php echo $row['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php
                $no++;
            }
        } else {
            // Jika tidak ada data
            echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
        }
        ?>
    </table>

    <!-- Tombol untuk logout -->
    <form method="post" action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>

</html>