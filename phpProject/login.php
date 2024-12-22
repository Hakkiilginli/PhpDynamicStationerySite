<?php
session_start();
include('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanında ara
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $db_username, $db_password, $role);
    $stmt->fetch();

    // Şifreyi kontrol et
    if ($password === $db_password) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['role'] = $role;

        // Admin kullanıcıyı admin paneline yönlendir
        if ($role === 'admin') {
            header("Location: admin/admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error_message = "Geçersiz kullanıcı adı veya şifre!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title>Giriş Yap</title>
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
                    <li><a href="bize_ulasin.php" class="nav-link">Bize Ulaşın</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Login Form -->
    <div class="form-container">
        <h2>Giriş Yap</h2>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php" class="login-form">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" placeholder="Kullanıcı Adı" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" placeholder="Şifre" required>
            </div>
            <button type="submit" class="btn">Giriş Yap</button>
        </form>
        <p>Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
    </div>

</body>
</html>
