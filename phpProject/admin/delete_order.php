<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('../db/connection.php');

// GET ile gelen order_id parametresini kontrol et
if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']); // ID'yi tam sayı olarak al

    if ($orderId > 0) {
        // Siparişi silmek için SQL sorgusu
        $sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Sipariş başarıyla silindi.";
        } else {
            $_SESSION['error'] = "Sipariş silinirken bir hata oluştu: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Geçersiz sipariş ID.";
    }
} else {
    $_SESSION['error'] = "Silmek için bir sipariş seçilmedi.";
}

$conn->close();
header("Location: view_orders.php");
exit();
?>
