<?php
session_start();
session_unset(); // Tüm oturum değişkenlerini temizler
session_destroy(); // Oturumu yok eder
header("Location: login.php"); // Giriş sayfasına yönlendir
exit();
?>
