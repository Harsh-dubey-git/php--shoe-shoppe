<?php
session_start(); // Ensure session is started
include '../config/database.php'; // Your PDO connection

$username = $_SESSION['username'] ?? 'brandy81'; // fallback for testing
$recommendedIds = [];

// Fetch recommended product IDs from Python API
$apiUrl = "http://localhost:5000/api/recommendations?username=" . urlencode($username);

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

if ($response !== false) {
    $data = json_decode($response, true);
    $recommendedIds = $data['recommended_products'] ?? [];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Product Catalog</title>
    <!-- Bootstrap and Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">

    <style>
    * {
        font-family: 'Quicksand', sans-serif;
    }

    .product-card {
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.05);
    }

    .carousel-inner img {
        object-fit: contain;
        background-color: #f0f0f0;
        width: 100%;
        height: 67vh;
    }

    .carousel-caption {
        background-color: rgba(255, 255, 255, 0.7);
        padding: 1rem;
        border-radius: 0.5rem;
    }
</style>

</head>

<body>
    <!-- Header -->
    <div class="sticky-top bg-white shadow" style="z-index: 1000;">
        <?php include 'Header.php'; ?>
    </div>

    <!-- Carousel -->
    <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://i.pinimg.com/736x/36/54/53/36545338fdb8a92e306a59f998686030.jpg" style="" alt="Sneakers">
                <div class="carousel-caption text-dark">
                    <h5 class="display-3">Nike Air +1</h5>
                    <h4>Find the perfect SNEAKER'S for your needs.</h4>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://i.pinimg.com/736x/a1/ce/b8/a1ceb818675ef95b4de6751f6c94f2e2.jpg" alt="Office Wear">
                <div class="carousel-caption text-dark">
                    <h5 class="display-3">Office Ware</h5>
                    <h4>Find the perfect shoes for your needs.</h4>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../Assets/Adds/shoes.jpg" alt="Jordan">
                <div class="carousel-caption text-dark">
                    <h5 class="display-3">Jorden Light</h5>
                    <h4>Enhance your creativity.</h4>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

  <!-- Product Cards -->
<div class="container my-5">
    <h2 class="text-center mb-4 text-primary">Recommended Products</h2>
    <div class="d-flex flex-wrap justify-content-center gap-4">
        <?php
        if (!empty($recommendedIds)) {
            $placeholders = rtrim(str_repeat('?,', count($recommendedIds)), ',');
            $sql = "SELECT p.*, b.BrandName, 
                    GROUP_CONCAT(i.ImageName ORDER BY i.ImageName ASC SEPARATOR ',') AS ImageNames
                    FROM ProductDataTbl p
                    LEFT JOIN BrandsTbl b ON p.BrandId = b.BrandId
                    LEFT JOIN ProductImageTbl i ON p.ProductId = i.ProductId
                    WHERE p.ProductId IN ($placeholders)
                    GROUP BY p.ProductId, b.BrandName";

            $stmt = $conn->prepare($sql);
            $stmt->execute($recommendedIds);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $row) {
                echo '<a class="text-decoration-none" href="Details.php?PID=' . $row['ProductId'] . '">';
                echo '<div class="card product-card p-3 shadow" style="width: 15rem;">';

                $fallbackImage = "https://i.pinimg.com/736x/6a/4c/8f/6a4c8fa3fcd4115c3566704f56d8673f.jpg";
                $imagePath = $fallbackImage;

                if (!empty($row['ImageNames'])) {
                    $images = explode(',', $row['ImageNames']);
                    $imagePath = "../Assets/Products/" . $images[0];
                }

                echo '<img class="card-img-top" src="' . $imagePath . '" alt="Product Image" onerror="this.onerror=null;this.src=\'' . $fallbackImage . '\'">';

                echo '<div class="card-body">';
                echo '<p class="text-primary mb-1">Brand: ' . htmlspecialchars($row['BrandName']) . '</p>';
                echo '<h5 class="card-title text-dark">' . htmlspecialchars($row['ProductName']) . '</h5>';
                echo '<p class="text-success">Price: ₹' . intval($row['ProductPrice']) . '</p>';
                echo '<p class="text-muted" style="text-decoration: line-through;">₹' . intval($row['ProductSellingPrice']) . '</p>';
                $discount = intval($row['ProductPrice']) - intval($row['ProductSellingPrice']);
                echo '<span class="badge bg-primary">Discount: ₹' . $discount . '</span>';
                echo '</div></div></a>';
            }
        } else {
            echo '<p class="text-center text-muted">No recommended products found.</p>';
        }
        ?>
    </div>
</div>


    <!-- Footer -->
    <div class="sticky-bottom mt-5">
        <?php include 'Footer.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
