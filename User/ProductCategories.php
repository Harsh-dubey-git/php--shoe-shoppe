<!DOCTYPE html>
<html>

<head>
    <title>Product Catalog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>

<body>
    <div class="sticky-top" style="z-index: 7;">
        <?php
        include 'Header.php';
        ?>
    </div>

    <div class="container p-4">
        <?php
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "NewPassword";
        $dbname = "ShoeStore";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the category name from the query string
        $categoryName = $_GET['CATNAME'];

        // Prepare the SQL query with a parameterized statement
        $sql = "SELECT p.*, b.BrandName, i.ImageName, i.ImageExtension
                FROM ProductDataTbl p
                LEFT JOIN BrandsTbl b ON p.BrandId = b.BrandId
                LEFT JOIN (
                    SELECT ProductId, ImageName, ImageExtension
                    FROM ProductImageTbl
                    GROUP BY ProductId
                ) i ON p.ProductId = i.ProductId
                INNER JOIN CategoriesTbl c ON p.CategoryId = c.CategoryId
                WHERE c.CategoryName = ?";

        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind the category name parameter to the statement
        $stmt->bind_param("s", $categoryName);

        // Execute the statement
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a class="text-decoration-none" href="Details.php?PID=' . $row['ProductId'] . '">';
                echo '<div class="card product-card p-3 shadow" style="width: 15rem;">';

                // Display product image if available
                if (!empty($row['ImageName']) && !empty($row['ImageExtension'])) {
                    $imagePath = "../Assets/Products/" . $row['ImageName'] . "";
                    echo '<img class="product-image" src="' . $imagePath . '" alt="Product Image">';
                }
                echo '<p class="text-primary">Brand: ' . $row['BrandName'] . '</p>';
                echo '<h4 class="text-dark">' . $row['ProductName'] . '</h4>';
                echo '<h4 class="text-success">Price: ₹' . intval($row['ProductPrice']) . '</p>';
                echo '<h6 style="text-decoration:line-through" class="text-danger">₹' . intval($row['ProductSellingPrice']) . '</p>';
                $discount = intval($row['ProductPrice']) - intval($row['ProductSellingPrice']);
                echo '<p class="badge bg-primary text-light">Discount: ₹' . $discount . '</p>';

                echo '</div>';
                echo '</a>';
            }
        } else {
            echo '<p>No products found.</p>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
    <div class="sticky-top" style="z-index: 7;">
        <?php
include 'Footer.php';
?></div>
</body>

</html>
