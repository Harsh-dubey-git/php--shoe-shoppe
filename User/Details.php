<!DOCTYPE html>
<html>

<head>
    <title>Product Details</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f8f9fa;
        }

        .product-card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: #ffffff;
        }

        .product-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product-details {
            margin-bottom: 20px;
        }

        .product-description {
            margin-bottom: 20px;
        }

        .product-highlights {
            margin-bottom: 20px;
        }

        .product-image {
            height: 500px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #000;
            height: 30px;
            width: 30px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="sticky-top" style="z-index: 7;">
        <?php
        include 'Header.php';
        ?></div>
    <?php


    // Check if the ProductId is provided in the query string
    if (isset($_GET['PID'])) {
        // Assuming you have established a database connection
        $servername = "localhost";
        $username = "root";
        $password = "NewPassword";
        $dbname = "ShoeStore";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve product details
        $productId = $_GET['PID'];
        $query = "SELECT * FROM ProductDataTbl WHERE ProductId = $productId";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $productName = $row['ProductName'];
            $productPrice = $row['ProductPrice'];
            $productSellingPrice = $row['ProductSellingPrice'];
            $productStock = $row['ProductStock'];
            $productDetails = $row['ProductDetails'];
            $productDescription = $row['ProductDescription'];
            $productHighlight1 = $row['ProductHighlight1'];
            $productHighlight2 = $row['ProductHighlight2'];

            // Retrieve product images
            $query = "SELECT * FROM ProductImageTbl WHERE ProductId = $productId";
            $result = $conn->query($query);
            $productImages = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $productImages[] = $row['ImageName'];
                }
            }

            // Handle Add to Cart button click
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add-to-cart'])) {
                $userNameValue = $_SESSION["username"]; // Get the username from the session

                // Check if a size is selected
                if (isset($_POST['size'])) {
                    $selectedSize = $_POST['size']; // Selected size

                    // Insert the product and selected size into the UserCartTbl table
                    $dateTime = date('Y-m-d H:i:s');
                    $insertQuery = "INSERT INTO UserCartTbl (ProductId, DateTime, Size, UserName) VALUES ($productId, '$dateTime', '$selectedSize', '" . $_SESSION["username"] . "')";
                    if ($conn->query($insertQuery) === TRUE) {
                        echo "<script>alert('Product added to cart successfully!');</script>";
                    } else {
                        echo "<script>alert('Error adding product to cart: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Please select a size.');</script>";
                }
            }



            // Close the database connection
            $conn->close();
    ?>

            <div class="container p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-card">
                        <form method="post" action="">

                            <h1 class="product-name"><?php echo $productName; ?></h1>
                            <p class="product-price btn p-2 btn-warning h3">Price: <?php echo intval($productPrice); ?></p>
                            <p class="product-price btn btn-danger text-light" style="text-decoration: line-through;">Selling Price: <?php echo intval($productSellingPrice); ?></p>
                            <p class="product-details">Details: <?php echo $productDetails; ?></p>
                            <p class="product-description">Description: <?php echo $productDescription; ?></p>
                            <div class="product-highlights">
                                <p class="mb-1">Highlights:</p>
                                <ul class="pl-3 mb-0">
                                    <li><?php echo $productHighlight1; ?></li>
                                    <li><?php echo $productHighlight2; ?></li>
                                </ul>
                            </div>

                                <div class="product-sizes my-4">
                                    <p>Select Size:</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="size" id="size-s" value="S">
                                        <label class="form-check-label" for="size-s">S</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="size" id="size-m" value="M">
                                        <label class="form-check-label" for="size-m">M</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="size" id="size-l" value="L">
                                        <label class="form-check-label" for="size-l">L</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="size" id="size-xl" value="XL">
                                        <label class="form-check-label" for="size-xl">XL</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="size" id="size-xxl" value="XXL">
                                        <label class="form-check-label" for="size-xxl">XXL</label>
                                    </div>
                                </div>

                                <form method="post">
    <button class="btn btn-primary" type="submit" name="add-to-cart">Add to Cart</button>
    <a href="#" onclick="buyNow()" class="btn btn-success">Buy Now</a>
</form>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php
                                // Generate carousel indicators
                                foreach ($productImages as $key => $image) {
                                    $activeClass = ($key === 0) ? 'active' : '';
                                    echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $key . '" class="' . $activeClass . '"></li>';
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php
                                // Generate carousel items
                                foreach ($productImages as $key => $image) {
                                    $activeClass = ($key === 0) ? 'active' : '';
                                    echo '<div class="carousel-item ' . $activeClass . '">';
                                    echo '<img class="d-block w-100 product-image" src="../Assets/Products/' . $image . '" alt="Product Image">';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

    <?php
        } else {
            echo "No product found.";
        }
    } else {
        echo "Product ID not provided.";
    }
    ?>
    <div class="sticky-top" style="z-index: 7;">
        <?php
        include 'Footer.php';
        ?></div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
    function buyNow() {
        var selectedSize = document.querySelector('input[name="size"]:checked');
        if (!selectedSize) {
            alert("Please select a size.");
        } else {
            var size = selectedSize.value;
            window.location.href = "Payment.php?PID=<?php echo $productId; ?>&SIZE=" + size;
        }
    }
</script>
</body>

</html>