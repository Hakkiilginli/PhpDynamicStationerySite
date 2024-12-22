<?php
session_start();
include('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanına ekle
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, 'user', NOW())");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Kayıt başarıyla tamamlandı. Giriş yapabilirsiniz.'); window.location.href='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/logo.png" type="image/png">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title>Kayıt Ol</title>
</head>
<body>
     <!-- Header (Navbar) -->
     <header class="main-header">
        <div class="header-container">
            <div class="logo-container">
                <img class="logo" src="images/logo.png" alt="Logo">
                <span class="store-name">SuHa Kırtasiye</span>
            </div>
            <nav class="header-nav">
                <ul class="nav-links">
                    <li><a href="index.php" class="nav-link">Anasayfa</a></li>
                    <li><a href="login.php" class="nav-link">Giriş Yap</a></li>
                    <li><a href="register.php" class="nav-link">Kayıt Ol</a></li>
                    <li><a href="contact.php" class="nav-link">Bize Ulaşın</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="form-container">
        <h2>Kayıt Ol</h2>
        <form method="POST" action="register.php" class="register-form">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" placeholder="Kullanıcı Adı" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" placeholder="Şifre" required>
            </div>
            <button type="submit" class="btn">Kayıt Ol</button>
        </form>
        <p>Zaten bir hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
    </div>
</body>
</html>
