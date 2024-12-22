<?php
session_start();
include('db/connection.php');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepet</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body>
   <!-- Header Bölümü -->
   <header class="main-header">
        <div class="header-container">
            <div class="logo-container">
                <img src="images/logo.png" alt="Suha Kırtasiye Mağazası Logo" class="logo">
                <span class="store-name">SUHA Kırtasiye Mağazası</span>
            </div>
            <nav class="header-nav">
                <ul class="nav-links">
                    <li><a href="index.php" class="nav-link">Ana Sayfa</a></li>
                    <li><a href="cart_display.php" class="nav-link">Sepetim</a></li>
                    <li><a href="bize_ulasin.php" class="nav-link">Bize Ulaşın</a></li>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <li><span class="welcome-msg">Hoşgeldiniz, <?php echo $_SESSION['username']; ?>!</span></li>
                        <li><a href="logout.php" class="nav-link">Çıkış Yap</a></li>
                    <?php else : ?>
                        <li><a href="login.php" class="nav-link">Giriş Yap</a></li>
                        <li><a href="register.php" class="nav-link">Kayıt Ol</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Sepet İçeriği -->
    <main>
        <?php
        // Sepet boşsa kullanıcıyı tablo ve buton ile uyar
        if (empty($_SESSION['cart'])) {
            echo "<div class='cart-empty'>";
            echo "<h2>Sepetiniz Boş</h2>";
            echo "<table class='empty-cart-table'>";
            echo "<tr><td>Sepetinizde ürün bulunmamaktadır.</td></tr>";
            echo "</table>";
            echo "<div class='return-home'>";
          //  echo "<a href='index.php' class='btn'>Anasayfaya Dön</a>";
            echo "</div>";
            echo "</div>";
        } else {
            // Sepet içeriğini göster
            echo "<div class='cart-section'>";
            echo "<h2>Sepetiniz</h2>";
            echo "<table class='cart-table'>";
            echo "<tr><th>Ürün Adı</th><th>Fiyat</th><th>Miktar</th><th>Toplam</th><th>Stok</th><th>Sil</th></tr>";

            $total_price = 0;

            foreach ($_SESSION['cart'] as $item) {
                $product_id = $item['product_id'];
                $sql = "SELECT * FROM products WHERE id = $product_id";
                $result = $conn->query($sql);
                $product = $result->fetch_assoc();

                $total = $product['price'] * $item['quantity'];
                $total_price += $total;
                $available_stock = $product['stock'];

                echo "<tr>";
                echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                echo "<td>₺" . htmlspecialchars($product['price']) . "</td>";
                echo "<td>" . $item['quantity'] . "</td>";
                echo "<td>₺" . $total . "</td>";
                echo "<td>" . $available_stock . " adet</td>";
                echo "<td><a href='remove_from_cart.php?product_id=$product_id' class='remove-btn'>Sil</a></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<div class='cart-summary'>";
            echo "<p><strong>Toplam: ₺" . $total_price . "</strong></p>";

            if (!isset($_SESSION['username'])) {
                echo "<p class='warning'>Sipariş verebilmek için <a href='login.php'>giriş yapmanız</a> gerekiyor.</p>";
                echo "<p><a href='login.php' class='btn'>Giriş Yap</a></p>";
            } else {
                echo "<p><a href='checkout.php' class='btn'>Sipariş Ver</a></p>";
            }

            echo "<p><a href='empty_cart.php' class='btn btn-danger'>Sepeti Boşalt</a></p>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 SUHA Kırtasiye Mağazası. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>
