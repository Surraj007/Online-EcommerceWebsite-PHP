<?php
require 'db.php';  

try {
    $query = $db->query("SELECT * FROM products");  
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
    $products = [];  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple E-Commerce Site</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Store</h1>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="images/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                    <h3><?= $product['name']; ?></h3>
                    <p><?= $product['description']; ?></p>
                    <p>$<?= number_format($product['price'], 2); ?></p>
                    <a href="product.php?id=<?= $product['id']; ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
