<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Giriş sayfasına yönlendir
    exit();
}

include('../db/connection.php');

// Siparişleri veritabanından çek
$sql = "SELECT orders.id, orders.user_id, orders.total_price, orders.status, orders.created_at, users.username
        FROM orders
        JOIN users ON orders.user_id = users.id
        ORDER BY orders.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siparişler - Admin Paneli</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar (Sol Menü) -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Paneli</h2>
            </div>
            <ul class="sidebar-links">
                <li><a href="add_product.php" class="sidebar-link">Ürün Ekle</a></li>
                <li><a href="view_products.php" class="sidebar-link">Ürünleri Görüntüle</a></li>
                <li><a href="view_orders.php" class="sidebar-link">Siparişleri Görüntüle</a></li> <!-- Siparişler butonu -->
                <li><a href="view_users.php" class="sidebar-link">Kullanıcıları Görüntüle</a></li> <!-- Kullanıcılar yönetimi -->
                <li><a href="view_contact_form.php" class="sidebar-link">Gelen Mesajlar</a></li> <!-- Mesajlar butonu -->
                <li><a href="../logout.php" class="sidebar-link">Çıkış Yap</a></li>
            </ul>
        </aside>

        <!-- Ana İçerik -->
        <main class="main-content">
            <header class="main-header">
                <h1>Siparişler</h1>
                <?php if (isset($_SESSION['success'])) : ?>
                    <p class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])) : ?>
                    <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
            </header>

            <section class="order-grid">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Sipariş ID</th>
                            <th>Kullanıcı Adı</th>
                            <th>Toplam Fiyat</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td>₺<?php echo htmlspecialchars($row['total_price']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <a href="order_details.php?order_id=<?php echo $row['id']; ?>" class="btn btn-primary">Detay Gör</a>
                                    <a href="delete_order.php?order_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bu siparişi silmek istediğinize emin misiniz?');">Sil</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
