<?php
session_start();
include('../db/connection.php');  // Veritabanı bağlantısını yap

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Ürünü veritabanından almak
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);  // Parametreyi bağlama (mysqli)
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Ürünün resmini ve yolunu al
        $image = $product['image'];
        
        // Veritabanından ürünü silme
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);  // Parametreyi bağlama (mysqli)

        if ($stmt->execute()) {
            // Eğer resim varsa, resmi dosya sisteminden sil
            if ($image) {
                $image_path = "../images/" . basename($image); // Resmin tam yolu
                if (file_exists($image_path)) {
                    unlink($image_path);  // Dosyayı sil
                }
            }

            // Ürün başarıyla silindiyse, admin ürün sayfasına yönlendir
            header("Location: view_products.php");
            exit;
        } else {
            echo "Ürün silinemedi!";
        }
    } else {
        echo "Ürün bulunamadı!";
    }
} else {
    // Eğer ürün ID'si yoksa, ürünler listesine yönlendir
    header("Location: view_products.php");
    exit;
}
?>
