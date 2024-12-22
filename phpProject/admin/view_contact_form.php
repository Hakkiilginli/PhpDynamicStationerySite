<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Giriş sayfasına yönlendir
    exit();
}

// Veritabanı bağlantısı
include('../db/connection.php');

// Mesajları al
$sql = "SELECT * FROM contact_form ORDER BY created_at DESC"; // 'submitted_at' yerine 'created_at' kullanıldı
$result = $conn->query($sql);

// Hata kontrolü: Sorgu başarısız mı?
if ($result === false) {
    die("Sorgu hatası: " . $conn->error); // Veritabanı hatası varsa göster
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelen Mesajlar - SUHA Kırtasiye Mağazası</title>
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
                <h1>Gelen Mesajlar</h1>
            </header>

            <section class="product-grid">
                <?php 
                // Eğer sonuç varsa, mesajları listele
                if ($result->num_rows > 0): 
                ?>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Adı</th>
                                <th>E-posta</th>
                                <th>Mesaj</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($message = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo htmlspecialchars($message['created_at']); ?></td> <!-- 'submitted_at' yerine 'created_at' kullanıldı -->
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Henüz gelen mesaj yok.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>

</html>
