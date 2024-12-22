<?php
session_start();

// Admin kontrolü
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Admin değilse login sayfasına yönlendir
    exit();
}

include('../db/connection.php');

// Gelen order_id parametresini al
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    // Sipariş bilgilerini getir
    $sql_order = "SELECT orders.*, users.username FROM orders 
                  JOIN users ON orders.user_id = users.id 
                  WHERE orders.id = ?";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("i", $order_id);
    $stmt_order->execute();
    $order_result = $stmt_order->get_result();

    if ($order_result->num_rows > 0) {
        $order = $order_result->fetch_assoc();

        // Sipariş ürünlerini getir
        $sql_items = "SELECT order_items.*, products.name, products.price 
                      FROM order_items 
                      JOIN products ON order_items.product_id = products.id 
                      WHERE order_items.order_id = ?";
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $items_result = $stmt_items->get_result();
    } else {
        die("Sipariş bulunamadı.");
    }
} else {
    die("Geçersiz sipariş ID.");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Detayları</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
</head>
<body>
    <div class="order-details">
        <h1>Sipariş Detayları</h1>
        <p><strong>Sipariş ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Kullanıcı Adı:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
        <p><strong>Toplam Fiyat:</strong> ₺<?php echo htmlspecialchars($order['total_price']); ?></p>
        <p><strong>Durum:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Tarih:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>

        <h2>Ürünler</h2>
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Adet</th>
                    <th>Birim Fiyat</th>
                    <th>Toplam</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₺<?php echo htmlspecialchars($item['price']); ?></td>
                        <td>₺<?php echo htmlspecialchars($item['quantity'] * $item['price']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Geri Dön Butonu -->
        <form action="view_orders.php" method="get" style="text-align: center; margin-top: 20px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Geri Dön</button>
        </form>
    </div>

    <footer>
        <p>&copy; SuHa Kırtasiye Mağazası | Tüm Hakları Saklıdır</p>
    </footer>

    <?php
    // Bağlantıyı kapatıyoruz
    $items_result->free();
    $stmt_items->close();
    $stmt_order->close();
    ?>
</body>
</html>
