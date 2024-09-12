<?php
class koneksi {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $database = "users";
    protected $koneksi;

    public function __construct(){
        try {
            // Menggunakan PDO untuk menghubungkan ke database MySQL
            $this->koneksi = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->pass);
            // Mengatur mode error menjadi exception
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            // Menampilkan pesan error jika terjadi kesalahan koneksi
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }

    // Metode untuk mendapatkan koneksi
    public function getKoneksi(){
        return $this->koneksi;
    }
}
?>
