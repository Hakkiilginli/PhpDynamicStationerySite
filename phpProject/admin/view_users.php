<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Giriş sayfasına yönlendir
    exit();
}

include('../db/connection.php');

// Kullanıcıları veritabanından çek
$sql = "SELECT id, username, created_at, role FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcılar - Admin Paneli</title>
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
                <li><a href="view_orders.php" class="sidebar-link">Siparişleri Görüntüle</a></li> <!-- Siparişler butonu eklendi -->
                <li><a href="view_users.php" class="sidebar-link">Kullanıcıları Görüntüle</a></li> <!-- Kullanıcılar yönetimi -->
                <li><a href="view_contact_form.php" class="sidebar-link">Gelen Mesajlar</a></li> <!-- Yeni Mesajlar butonu -->
                <li><a href="../logout.php" class="sidebar-link">Çıkış Yap</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Kullanıcılar</h1>
            </header>

            <section class="product-grid">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Kullanıcı ID</th>
                            <th>Kullanıcı Adı</th>
                            <th>Rol</th>
                            <th>Kayıt Tarihi</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <a href="delete_user.php?user_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">Sil</a>
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
