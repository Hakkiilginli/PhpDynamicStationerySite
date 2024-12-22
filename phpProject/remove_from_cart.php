<?php
session_start();

// Sepetten ürün silme işlemi
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Sepetteki ürünü arayıp bulalım ve silelim
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

// Sepet sayfasına yönlendirelim
header("Location: cart_display.php");
exit;
?>
