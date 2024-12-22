<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUHA Kırtasiye Mağazası</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    
</head>

<body>
   <!-- Header Bölümü -->
<header class="main-header">
    <div class="header-container">
        <div class="logo-container">
            <!-- Logoyu tıklanabilir yapmak için <a> etiketi ekledik -->
            <a href="index.php">
                <img src="images/logo.png" alt="Suha Kırtasiye Mağazası Logo" class="logo">
            </a>
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

    <main>
        <section class="product-section">
            <h2>Ürünlerimiz</h2>
            <div class="product-grid">
                <?php
                include('db/connection.php');
                $sql = "SELECT * FROM products"; // Stok bilgisi de alınacak
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '<img src="images/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
                        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
                        echo '<p>' . htmlspecialchars($product['description']) . '</p>';
                        echo '<span class="price">₺' . htmlspecialchars($product['price']) . '</span>';
                        echo '<p class="stock-info">Stok: ' . htmlspecialchars($product['stock']) . ' adet</p>'; // Stok bilgisi
                        echo '<form method="POST" action="cart.php">';
                        echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                        echo '<input type="number" name="quantity" value="1" min="1" max="' . $product['stock'] . '" required>';
                        if ($product['stock'] > 0) {
                            echo '<button type="submit" class="btn">Sepete Ekle</button>';
                        } else {
                            echo '<button type="submit" class="btn" disabled>Stokta Yok</button>';
                        }
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Ürün bulunamadı.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 SUHA Kırtasiye Mağazası. Tüm Hakları Saklıdır.</p>
    </footer>

</body>

</html>
