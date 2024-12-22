<?php
session_start();

// Veritabanı bağlantısını ekleyin
include('db/connection.php');

// Form gönderildiğinde veriyi kaydet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Veritabanına veri ekleyin
    $sql = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        $success_message = "Mesajınız başarıyla gönderildi!";
    } else {
        $error_message = "Hata: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUHA Kırtasiye Mağazası - Bize Ulaşın</title>
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

    <!-- Bize Ulaşın Bölümü -->
    <main>
        <section class="contact-section">
            <h2>Bize Ulaşın</h2>
            
            <!-- Başarı ve Hata mesajları -->
            <?php if (isset($success_message)) : ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)) : ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- İletişim Formu -->
            <form action="bize_ulasin.php" method="POST">
                <label for="name">Adınız:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">E-posta:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Mesajınız:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit" class="btn">Gönder</button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 SUHA Kırtasiye Mağazası. Tüm Hakları Saklıdır.</p>
    </footer>

</body>

</html>
