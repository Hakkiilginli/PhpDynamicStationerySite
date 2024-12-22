<?php
session_start();
include('db/connection.php');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş</title>
    <link rel="stylesheet" href="css/style.css"> <!-- style.css dosyasını bağladık -->
</head>
<body>

<?php
// Kullanıcı girişi kontrolü
if (!isset($_SESSION['username'])) {
    echo "<p>Lütfen giriş yapın.</p>";
    exit;
}

if (empty($_SESSION['cart'])) {
    echo "<p>Sepetiniz boş. Lütfen ürün ekleyin.</p>";
    exit;
}

// Kullanıcı bilgilerini alalım
$user_id = $_SESSION['user_id'];  // Kullanıcının ID'si session'dan alınır
$total_price = 0;

// Siparişi veritabanına kaydet
$conn->begin_transaction(); // Başlat transaction

try {
    // Sipariş kaydı oluştur
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $user_id, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;  // Yeni siparişin ID'sini al

    // Sepet içeriğini `order_items` tablosuna ekle
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $stmt = $conn->prepare("SELECT price, stock FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $price = $product['price'];
        $stock = $product['stock'];

        // Stok kontrolü ve güncelleme
        if ($quantity > $stock) {
            throw new Exception("Yeterli stok yok: " . $product['name']);
        }

        // Stok güncelle
        $new_stock = $stock - $quantity;
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_stock, $product_id);
        $stmt->execute();

        // Sipariş detaylarını kaydet
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);
        $stmt->execute();

        // Toplam fiyat hesapla
        $total_price += $price * $quantity;
    }

    // Siparişi güncelle (toplam fiyat)
    $stmt = $conn->prepare("UPDATE orders SET total_price = ? WHERE id = ?");
    $stmt->bind_param("di", $total_price, $order_id);
    $stmt->execute();

    // Transaction başarıyla tamamlandı
    $conn->commit();

    // Ödeme başarılı mesajı
    echo "<p class='success'>Ödemeniz alındı ve siparişiniz başarıyla oluşturuldu. Sipariş numaranız: $order_id</p>";

    // Sepeti temizle
    unset($_SESSION['cart']);
} catch (Exception $e) {
    // Bir hata oluştuysa transaction'ı geri al
    $conn->rollback();
    echo "<p class='error'>Bir hata oluştu: " . $e->getMessage() . "</p>";
}
?>

</body>
</html>
