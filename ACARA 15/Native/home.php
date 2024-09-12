<?php
require("koneksi.php");

session_start();

// Cek apakah user sudah login, jika tidak redirect ke login.php
if (!isset($_SESSION['id'])) {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
    exit();
}

// Ambil data dari session
$sesID = $_SESSION['id'];
$sesName = $_SESSION['name'];
$sesLvl = $_SESSION['level'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Selamat Datang, <?php echo htmlspecialchars($sesName); ?></h1>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data user
                $query = "SELECT * FROM user_detail";
                $result = mysqli_query($koneksi, $query);

                // Cek apakah query berhasil
                if ($result) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $userMail = htmlspecialchars($row['user_email']);
                        $userName = htmlspecialchars($row['user_fullname']);

                        // Menentukan apakah tombol edit dan hapus bisa diakses
                        $dis = ($sesLvl == 1) ? "" : "disabled";
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $userMail; ?></td>
                    <td><?php echo $userName; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-primary btn-sm <?php echo $dis; ?>">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-danger btn-sm <?php echo $dis; ?>">Hapus</a>
                    </td>
                </tr>
                <?php
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='4'>Data tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <p><a href="logout.php" class="btn btn-secondary">Logout</a></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>