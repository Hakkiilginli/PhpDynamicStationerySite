<?php
session_start();
include('db/connection.php');

// Sepet, session'da tutuluyor
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sepete ürün ekleme
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Ürünü veritabanından alalım
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if ($product) {
        // Stok bilgisi
        $available_stock = $product['stock'];

        // Stok kontrolü
        if ($quantity > $available_stock) {
            // Kullanıcıyı bilgilendirelim
            echo "<script>alert('Stokta yeterli ürün yok. Mevcut stok: $available_stock'); window.history.back();</script>";
            exit;
        }

        // Ürünü sepeti kontrol ederek ekleyelim
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] += $quantity; // Aynı ürünü eklerse miktarını arttır
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Ürün sepetinize eklenmemişse, yeni bir ürün olarak ekleyin
            $_SESSION['cart'][] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }
}

// Sepet sayfasına yönlendirelim
header("Location: cart_display.php");
exit;
?>
