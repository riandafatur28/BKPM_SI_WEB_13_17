<?php
session_start(); // Memulai session di awal

// Class koneksi ke database
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "users";
    public $koneksi;

    public function __construct() {
        $this->koneksi = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }
}

// Class login untuk melakukan proses login
class Login {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function loginUser($email, $pass) {
        // Memastikan input email dan password tidak kosong
        if (!empty($email) && !empty(trim($pass))) {
            // Query untuk mengambil data user berdasarkan email
            $query = "SELECT * FROM user_detail WHERE user_email = ?";
            $stmt = $this->db->koneksi->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows != 0) {
                // Mengambil data dari hasil query
                $row = $result->fetch_assoc();
                $userVal = $row["user_email"];
                $passVal = $row["user_password"];
                $userName = $row['user_fullname'];

                // Validasi email dan password
                if ($userVal == $email && $passVal == $pass) {
                    // Set session setelah login berhasil
                    $_SESSION['user_fullname'] = $userName;
                    $_SESSION['user_email'] = $userVal;

                    // Redirect ke home.php
                    header('Location: home.php');
                    exit();
                } else {
                    $this->redirectWithError('User atau password salah!!');
                }
            } else {
                $this->redirectWithError('User tidak ditemukan!!');
            }
        } else {
            $this->redirectWithError('Data Tidak Boleh Kosong!!');
        }
    }

    // Fungsi untuk menampilkan pesan error dan redirect
    private function redirectWithError($error) {
        echo $error;
        header('Location: login.php');
        exit();
    }
}

// Inisialisasi objek database dan login
$db = new Database();
$login = new Login($db);

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    $email = $_POST['txt_email'];
    $pass = $_POST['txt_pass'];

    // Memanggil fungsi loginUser untuk memproses login
    $login->loginUser($email, $pass);
}
?>

<html>

<head>
    <title>Login Page</title>
</head>

<body>
    <form action="login.php" method="POST">
        <p>email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="txt_email"></p>
        <p>password : <input type="password" name="txt_pass"></p>
        <button type="submit" name="submit">Sign In</button>
    </form>
    <p><a href="register.php">Daftar</a></p>
</body>

</html>