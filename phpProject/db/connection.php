<?php
$host = 'localhost';       // Veritabanı sunucusu
$username = 'root';        // Veritabanı kullanıcı adı
$password = '';            // Veritabanı şifresi (varsayılan genelde boş)
$dbname = 'stationery_db'; // Veritabanı adı

// Veritabanına bağlanma
$conn = new mysqli($host, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}
?>
