<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Giriş sayfasına yönlendir
    exit();
}

include('../db/connection.php');

// Ürünleri ve stok bilgilerini veritabanından çekme
$stmt = $conn->prepare("SELECT id, name, description, price, stock, image FROM products"); // `stock` sütunu eklendi
$stmt->execute();
$result = $stmt->get_result();  // get_result() kullanarak sonuçları alıyoruz
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürünleri Görüntüle</title>
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
                <h1>Ürünler</h1>
                <a href="admin_dashboard.php" class="btn btn-primary">Admin Paneline Dön</a>
            </header>

            <section class="product-grid">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Ürün Adı</th>
                            <th>Açıklama</th>
                            <th>Fiyat</th>
                            <th>Stok</th>
                            <th>Resim</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['description']); ?></td>
                                <td><?php echo htmlspecialchars($product['price']); ?> TL</td>
                                <td><?php echo htmlspecialchars($product['stock']); ?> Adet</td>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100">
                                    <?php else: ?>
                                        <p>Resim Yok</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Düzenle</a>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Bu ürünü silmek istediğinizden emin misiniz?')">Sil</a>
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

<?php
// Bağlantıyı kapatıyoruz
$result->free();
$stmt->close();
?>
