<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme Sayfası</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body>
<?php
// Sepet kontrolü
if (empty($_SESSION['cart'])) {
    echo "<p class='empty-cart'>Sepetiniz boş. Lütfen ürün ekleyin.</p>";
} else {
    echo "<div class='checkout-container'>";
    echo "<h2>Ödeme Sayfası</h2>";
    echo "<p>Sepetinizdeki ürünleri onaylıyorsunuz:</p>";
    echo "<table class='cart-table'>";
    echo "<tr><th>Ürün Adı</th><th>Fiyat</th><th>Miktar</th><th>Toplam</th></tr>";

    $total_price = 0;

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        include('db/connection.php');
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        $product = $result->fetch_assoc();

        $total = $product['price'] * $item['quantity'];
        $total_price += $total;

        echo "<tr>";
        echo "<td>" . htmlspecialchars($product['name']) . "</td>";
        echo "<td>₺" . htmlspecialchars($product['price']) . "</td>";
        echo "<td>" . $item['quantity'] . "</td>";
        echo "<td>₺" . $total . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<p class='total-price'><strong>Toplam: ₺" . $total_price . "</strong></p>";
    echo "<p><a href='payment.php' class='btn'>Ödeme Yap</a></p>";
    echo "</div>";
}
?>
</body>
</html>
