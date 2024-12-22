<?php
session_start();

// Sepeti temizleyelim
$_SESSION['cart'] = [];

// Sepet sayfasına yönlendirelim
header("Location: cart_display.php");
exit;
?>
