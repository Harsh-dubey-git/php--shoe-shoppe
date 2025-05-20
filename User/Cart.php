<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "NewPassword";
$dbname = "ShoeStore";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items for the current user
$username = $_SESSION['username'];
$cartQuery = "SELECT UserCartTbl.CartId, UserCartTbl.ProductId,UserCartTbl.Size, UserCartTbl.DateTime, ProductDataTbl.ProductName, ProductDataTbl.ProductPrice, ProductDataTbl.ProductSellingPrice, ProductDataTbl.ProductDetails, ProductImageTbl.ImageName
              FROM UserCartTbl
              INNER JOIN ProductDataTbl ON UserCartTbl.ProductId = ProductDataTbl.ProductId
              INNER JOIN ProductImageTbl ON UserCartTbl.ProductId = ProductImageTbl.ProductId
              WHERE UserCartTbl.UserName = '$username'";
$cartResult = $conn->query($cartQuery);

// Fetch purchased products for the current user
$purchasedQuery = "SELECT ProductDeliveryTbl.DeliveryId, ProductDeliveryTbl.ProductId,ProductDeliveryTbl.Size, ProductDeliveryTbl.DateTime, ProductDataTbl.ProductName, ProductDataTbl.ProductPrice, ProductDataTbl.ProductSellingPrice, ProductDataTbl.ProductDetails, ProductImageTbl.ImageName
                   FROM ProductDeliveryTbl
                   INNER JOIN ProductDataTbl ON ProductDeliveryTbl.ProductId = ProductDataTbl.ProductId
                   INNER JOIN ProductImageTbl ON ProductDeliveryTbl.ProductId = ProductImageTbl.ProductId
                   WHERE ProductDeliveryTbl.UserName = '$username'";
$purchasedResult = $conn->query($purchasedQuery);

// Remove product from cart
if (isset($_GET['remove']) && isset($_GET['cart_id'])) {
    $cartId = $_GET['cart_id'];
    $removeQuery = "DELETE FROM UserCartTbl WHERE CartId = '$cartId'";
    $conn->query($removeQuery);
    header("Location: cart.php");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

   <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }
        
        h2 {
            margin-bottom: 30px;
        }
        .cart-item {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .product-image {
            width: 170px;
            height: 170px;
            margin-right: 10px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .product-details {
            float: left;
            width: 70%;
        }
        .product-details h4 {
            margin-top: 0;
        }
        .product-price {
            margin-top: 15px;
            font-weight: bold;
        }
        .purchased-item {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .delivery-date {
            font-weight: bold;
        }
        .btn-remove {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sticky-top" style="z-index: 7;">
        <?php
include 'Header.php';
?></div>

<div class="container p-4">
    <h2>Your Cart</h2>

    <?php if ($cartResult->num_rows > 0) : ?>
        <?php
        $prevCartId = null;
        while ($cartRow = $cartResult->fetch_assoc()) :
            if ($prevCartId != $cartRow['CartId']) {
                $prevCartId = $cartRow['CartId'];
                ?>
                <div class="cart-item">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="../Assets/Products/<?php echo $cartRow['ImageName']; ?>" class="product-image" alt="Product Image">
                        </div>
                        <div class="col-md-10">
                            <h4><?php echo $cartRow['ProductName']; ?></h4>
                            <p><?php echo $cartRow['ProductDetails']; ?></p>

                            <p class="btn btn-warning inline-block rounded-4 p-2">selected size : <?php echo $cartRow['Size']; ?></p>

                            <p class="product-price btn btn-success">Price: ₹<?php echo intval($cartRow['ProductPrice']); ?></p>
                            <p class="product-price text-danger" style="text-decoration: line-through;">Selling Price: ₹<?php echo intval($cartRow['ProductSellingPrice']); ?></p>
                            <a href="?remove=true&cart_id=<?php echo $cartRow['CartId']; ?>" class="btn btn-danger">Remove from Cart</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <h2>Your Purchased Products</h2>

    <?php if ($purchasedResult->num_rows > 0) : ?>
        <?php
        $prevDeliveryId = null;
        while ($purchasedRow = $purchasedResult->fetch_assoc()) :
            if ($prevDeliveryId != $purchasedRow['DeliveryId']) {
                $prevDeliveryId = $purchasedRow['DeliveryId'];
                ?>
                <div class="purchased-item">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="../Assets/Products/<?php echo $purchasedRow['ImageName']; ?>" class="product-image" alt="Product Image">
                        </div>
                        <div class="col-md-10">
                            <h4><?php echo $purchasedRow['ProductName']; ?></h4>
                            <p><?php echo $purchasedRow['ProductDetails']; ?></p>
                            <p class="btn btn-warning inline-block rounded-4 p-2">selected size : <?php echo $purchasedRow['Size']; ?></p>

                            <p class="product-price btn btn-success">Price: ₹<?php echo intval($purchasedRow['ProductPrice']); ?></p>
                            <p class="product-price text-danger" style="text-decoration: line-through;">Selling Price: ₹<?php echo intval($purchasedRow['ProductSellingPrice']); ?></p>
                            <p class="delivery-date">Delivery Date: <?php echo $purchasedRow['DateTime']; ?></p>
                        </div>
                    </div>
                </div>
                
            <?php } ?>
        <?php endwhile; ?>
    <?php else : ?>
        <p>You haven't purchased any products yet.</p>
    <?php endif; ?>
</div>
<div class="sticky-top" style="z-index: 7;">
    <?php
include 'Footer.php';
?></div>
</body>
</html>
