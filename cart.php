<?php
session_start();

include 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'add') {
        if (!in_array($id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $id;
        }
    } elseif ($action == 'remove') {
        if (($key = array_search($id, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

$productsInCart = [];
if (count($_SESSION['cart']) > 0) {
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $query = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $query->execute($_SESSION['cart']);
    $productsInCart = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Simple E-Commerce Site</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">Back to Home</a>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (count($productsInCart) > 0): ?>
            <div class="cart">
                <?php foreach ($productsInCart as $product): ?>
                    <div class="cart-item">
                        <img src="images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                        <h3><?= $product['name']; ?></h3>
                        <p>$<?= number_format($product['price'], 2); ?></p>
                        <a href="cart.php?action=remove&id=<?= $product['id']; ?>" class="btn">Remove</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
