<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('../db/connection.php');

// Silinecek kullanıcı ID'si
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Kullanıcıyı silme sorgusu
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Başarılıysa kullanıcıyı silip yönlendir
        header("Location: view_users.php?success=1");
    } else {
        // Hata durumunda
        echo "Hata: Kullanıcı silinirken bir problem oluştu.";
    }

    $stmt->close();
}

$conn->close();
?>
