<?php
session_start();

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Giriş sayfasına yönlendir
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../db/connection.php'); // Veritabanı bağlantısını yap

    // Formdan gelen verileri al
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // Dosya formatı kontrolü
    $allowed_formats = ['jpg', 'jpeg', 'png'];
    $image_extension = pathinfo($image, PATHINFO_EXTENSION); // Dosyanın uzantısını al

    if (!in_array(strtolower($image_extension), $allowed_formats)) {
        echo "Sadece .jpg, .jpeg ve .png formatlarında dosya yükleyebilirsiniz!";
        exit();
    }

    // Dosya yükleme işlemi
    if (!empty($image)) {
        $target_dir = "../images/";  // Resimlerin kaydedileceği doğru dizin
        $target_file = $target_dir . basename($image);

        // Dosyanın yüklenip yüklenmediğini kontrol et
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Yükleme başarılı
        } else {
            echo "Dosya yükleme hatası!";
            exit();
        }
    } else {
        $target_file = ''; // Eğer resim seçilmediyse boş bırak
    }

    // Ürün ekleme
    $query = "INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdis", $name, $description, $price, $stock, $target_file);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php"); // Ürün ekleme başarılıysa admin paneline yönlendir
        exit();
    } else {
        echo "Ürün eklenemedi!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle - Admin Paneli</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
</head>
<body>
    <div class="admin-container">
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
                <h1>Yeni Ürün Ekle</h1>
            </header>

            <section class="content">
                <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Ürün Adı</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Açıklama</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Fiyat</label>
                        <input type="text" id="price" name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stok</label>
                        <input type="number" id="stock" name="stock" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Ürün Resmi</label>
                        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png">
                    </div>

                    <button type="submit" class="btn btn-primary">Ürünü Ekle</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
