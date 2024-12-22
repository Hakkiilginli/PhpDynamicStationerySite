<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Giriş sayfasına yönlendir
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - SUHA Kırtasiye Mağazası</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
</head>
<body>
    <div class="admin-container">
        <!-- Sol Menü -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Paneli</h2>
            </div>
            <ul class="sidebar-links">
            <li><a href="add_product.php" class="sidebar-link">Ürün Ekle</a></li>
                <li><a href="view_products.php" class="sidebar-link">Ürünleri Görüntüle</a></li>
                <li><a href="view_orders.php" class="sidebar-link">Siparişleri Görüntüle</a></li> <!-- Siparişler butonu eklendi -->
                <li><a href="view_users.php" class="sidebar-link">Kullanıcıları Görüntüle</a></li> <!-- Kullanıcılar yönetimi -->
                <li><a href="view_contact_form.php" class="sidebar-link">Gelen Mesajlar</a></li> <!-- Yeni Mesajlar butonu -->
                <li><a href="../logout.php" class="sidebar-link">Çıkış Yap</a></li>
            </ul>
        </aside>

        <!-- Ana İçerik -->
        <main class="main-content">
            <header class="main-header">
                <h1>Admin Paneline Hoşgeldiniz</h1>
                <p>Merhaba, <?php echo $_SESSION['username']; ?>!</p>
            </header>

            <section class="content">
                <div class="content-card">
                    <h3>Ürün Ekle</h3>
                    <p>Yeni ürün eklemek için aşağıdaki butona tıklayın.</p>
                    <a href="add_product.php" class="btn btn-primary">Ürün Ekle</a>
                </div>

                <div class="content-card">
                    <h3>Ürünleri Görüntüle</h3>
                    <p>Var olan ürünleri görüntülemek için aşağıdaki butona tıklayın.</p>
                    <a href="view_products.php" class="btn btn-secondary">Ürünleri Görüntüle</a>
                </div>

                <div class="content-card">
                    <h3>Siparişleri Görüntüle</h3>
                    <p>Mevcut siparişleri görmek için aşağıdaki butona tıklayın.</p>
                    <a href="view_orders.php" class="btn btn-tertiary">Siparişleri Görüntüle</a>
                </div>

                <div class="content-card">
                    <h3>Kullanıcıları Görüntüle</h3>
                    <p>Siteye kayıtlı kullanıcıları görüntülemek için aşağıdaki butona tıklayın.</p>
                    <a href="view_users.php" class="btn btn-quaternary">Kullanıcıları Görüntüle</a>
                </div>

                <!-- Yeni Eklenen Buton -->
                <div class="content-card">
                    <h3>Gelen Mesajları Görüntüle</h3>
                    <p>Kullanıcıların gönderdiği mesajları görüntülemek için aşağıdaki butona tıklayın.</p>
                    <a href="view_contact_form.php" class="btn btn-quinary">Gelen Mesajları Görüntüle</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
