<?php include __DIR__ . '/includes/header.php'; ?>

<?php
$servername = "localhost";
$username = "root";
$password = "NewPassword";
$dbname = "ShoeStore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default SQL query
$sql = "SELECT p.ProductId, p.ProductName, p.ProductPrice, b.BrandName, c.CategoryName, p.ProductStock, d.DateTime, u.UserName
        FROM ProductDataTbl p
        LEFT JOIN BrandsTbl b ON p.BrandId = b.BrandId
        LEFT JOIN CategoriesTbl c ON p.CategoryId = c.CategoryId
        LEFT JOIN ProductDeliveryTbl d ON p.ProductId = d.ProductId
        LEFT JOIN UserDataTbl u ON d.UserName = u.UserName
        WHERE 1";

// Filters
if (!empty($_GET['product'])) {
    $sql .= " AND p.ProductName LIKE '%" . $_GET['product'] . "%'";
}
if (!empty($_GET['brand'])) {
    $sql .= " AND b.BrandName = '" . $_GET['brand'] . "'";
}
if (!empty($_GET['category'])) {
    $sql .= " AND c.CategoryName = '" . $_GET['category'] . "'";
}
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $sql .= " AND d.DateTime BETWEEN '" . $_GET['start_date'] . "' AND '" . $_GET['end_date'] . "'";
}
$sql .= " ORDER BY d.DateTime DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        .container {
            margin-top: 50px;
        }

        * {
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Sales Report</h2>
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="product" class="form-control" placeholder="Product Name" value="<?php echo $_GET['product'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="brand" class="form-control" placeholder="Brand" value="<?php echo $_GET['brand'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="category" class="form-control" placeholder="Category" value="<?php echo $_GET['category'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="<?php echo $_GET['start_date'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="<?php echo $_GET['end_date'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="report.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Purchase Date</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['ProductId']; ?></td>
                            <td><?php echo $row['ProductName']; ?></td>
                            <td>$<?php echo number_format($row['ProductPrice'], 2); ?></td>
                            <td><?php echo $row['BrandName']; ?></td>
                            <td><?php echo $row['CategoryName']; ?></td>
                            <td><?php echo $row['ProductStock']; ?></td>
                            <td><?php echo $row['DateTime']; ?></td>
                            <td><?php echo $row['UserName']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-4">
        
        <?php
        function generateTable($conn, $tableName) {
            echo "<h3 class='mt-4'>" . ucfirst($tableName) . "</h3>";
            $sql = "SELECT * FROM $tableName";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'><table class='table table-bordered table-striped'><thead><tr>";
                while ($field = $result->fetch_field()) {
                    echo "<th>" . $field->name . "</th>";
                }
                echo "</tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p>No data available in $tableName</p>";
            }
        }

        $tables = ["BrandsTbl", "CategoriesTbl", "ProductDataTbl", "ProductDeliveryTbl", "ProductImageTbl", "UserCartTbl", "UserDataTbl", "FeedbackTbl"];
        foreach ($tables as $table) {
            generateTable($conn, $table);
        }
        
        $conn->close();
        ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>