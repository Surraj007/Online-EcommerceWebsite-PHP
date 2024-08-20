<?php
include 'db.php';

$id = $_GET['id'];
$query = $db->prepare('SELECT * FROM products WHERE id = ?');
$query->execute([$id]);
$product = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name']; ?> - Simple E-Commerce Site</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">Back to Home</a>
    <div class="container">
        <div class="product-detail">
            <img src="images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
            <h1><?= $product['name']; ?></h1>
            <p><?= $product['description']; ?></p>
            <p>$<?= number_format($product['price'], 2); ?></p>
            <a href="cart.php?action=add&id=<?= $product['id']; ?>" class="btn">Add to Cart</a>
        </div>
    </div>
</body>
</html>
