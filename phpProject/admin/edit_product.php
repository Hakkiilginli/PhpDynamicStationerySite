<?php
session_start();
include('../db/connection.php');  // Veritabanı bağlantısını yap

// Admin kontrolü (admin değilse giriş sayfasına yönlendir)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Ürün düzenleme işlemi
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Ürün bilgilerini veritabanından çekme
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Eğer ürün bulunursa, formda göstermek için verileri al
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Ürün bulunamadı!";
        exit;
    }

    // Form submit işlemi
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock']; // Stok bilgisi formdan alınıyor
        $image = $_FILES['image']['name'];

        // Dosya yükleme işlemi
        if (!empty($image)) {
            $target_dir = "images/"; 
            $target_file = $target_dir . basename($image);

            // Dosya yüklemeden önce klasörün var olup olmadığını kontrol et
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);  // Klasör yoksa oluştur
            }

            // Dosyayı hedef klasöre yükle
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Dosya başarıyla yüklendi
            } else {
                echo "Dosya yükleme hatası!";
                exit;
            }
        } else {
            // Eğer resim değiştirilmemişse mevcut resmi koru
            $target_file = $product['image'];
        }

        // Ürün bilgilerini güncelleme
        $update_query = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('ssdisi', $name, $description, $price, $stock, $target_file, $product_id);

        if ($update_stmt->execute()) {
            header("Location: view_products.php"); 
            exit;
        } else {
            echo "Ürün güncellenemedi!";
        }
    }
} else {
    echo "Geçersiz ürün ID!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Düzenle</title>
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="icon" type="image/png" href="../images/logo.png">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Paneli</h2>
            </div>
            <ul class="sidebar-links">
                <li><a href="view_products.php" class="sidebar-link">Geri Dön</a></li>
                <li><a href="logout.php" class="sidebar-link">Çıkış Yap</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="main-header">
                <h1>Ürün Düzenle</h1>
            </div>
            <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data" class="form-container">
                <div class="form-group">
                    <label for="name">Ürün Adı</label>
                    <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Açıklama</label>
                    <textarea id="description" name="description" rows="4" required><?php echo $product['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Fiyat</label>
                    <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">Ürün Resmi</label>
                    <input type="file" id="image" name="image">
                    <img src="<?php echo $product['image']; ?>" alt="Ürün Resmi" style="width: 100px; margin-top: 10px;">
                </div>
                <button type="submit" class="btn">Güncelle</button>
            </form>
        </div>
    </div>
</body>
</html>
