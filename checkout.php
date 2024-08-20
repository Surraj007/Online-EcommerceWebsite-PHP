<?php
session_start();

include 'db.php';

$productsInCart = [];
if (count($_SESSION['cart']) > 0) {
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $query = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $query->execute($_SESSION['cart']);
    $productsInCart = $query->fetchAll(PDO::FETCH_ASSOC);
}

$total = array_sum(array_column($productsInCart, 'price'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Simple E-Commerce Site</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <?php if (count($productsInCart) > 0): ?>
            <p>Total: $<?= number_format($total, 2); ?></p>
            <form action="checkout.php" method="post">
                <input type="submit" name="checkout" value="Confirm Purchase" class="btn">
            </form>
            <?php
            if (isset($_POST['checkout'])) {
                // Handle payment logic here
                $_SESSION['cart'] = [];
                echo "<p>Thank you for your purchase!</p>";
            }
            ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
<a href="index.php">Back to Home</a>

    </div>
</body>
</html>
