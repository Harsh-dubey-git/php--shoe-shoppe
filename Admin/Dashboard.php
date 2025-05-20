<?php
// Include your database connection code here
$host = 'localhost';
$dbname = 'ShoeStore';
$username = 'root';
$password = 'NewPassword';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Query to fetch data for dashboard statistics
$usersQuery = "SELECT COUNT(*) AS totalUsers FROM UserDataTbl";
$productsQuery = "SELECT COUNT(*) AS totalProducts FROM ProductDataTbl";
$ordersQuery = "SELECT COUNT(*) AS totalOrders FROM ProductDeliveryTbl";

// Execute the queries and fetch the results
$totalUsers = 0;
$totalProducts = 0;
$totalOrders = 0;

try {
    $usersStmt = $conn->query($usersQuery);
    $totalUsers = $usersStmt->fetch(PDO::FETCH_ASSOC)['totalUsers'];

    $productsStmt = $conn->query($productsQuery);
    $totalProducts = $productsStmt->fetch(PDO::FETCH_ASSOC)['totalProducts'];

    $ordersStmt = $conn->query($ordersQuery);
    $totalOrders = $ordersStmt->fetch(PDO::FETCH_ASSOC)['totalOrders'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Quicksand', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            padding: 20px;
            text-align: center;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .card-body {
            font-size: 18px;
        }

        .countdown {
            animation: countup 2s ease-in-out;
        }

        @keyframes countup {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card countdown">
                    <div class="card-title">Total Users</div>
                    <div class="card-body"><?php echo $totalUsers; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card countdown">
                    <div class="card-title">Total Products</div>
                    <div class="card-body"><?php echo $totalProducts; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card countdown">
                    <div class="card-title">Total Orders</div>
                    <div class="card-body"><?php echo $totalOrders; ?></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        // Countup effect on dashboard values
        $('.countdown').each(function() {
            var $this = $(this);
            jQuery({
                Counter: 0
            }).animate({
                Counter: $this.text()
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.ceil(this.Counter));
                }
            });
        });
    </script>
</body>

</html>
