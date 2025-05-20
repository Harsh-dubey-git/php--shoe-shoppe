<?php
if (session_status() === PHP_SESSION_ACTIVE) {
   
}
else{
    session_start();

}

// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION['username'])) {
    header("Location: ./SignIn.php");
    exit;
}

// Check if the PID query string parameter is set
if (!isset($_GET['PID'])) {
    header("Location: ./index.php");
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "NewPassword";
$dbname = "ShoeStore";

// Process the payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $productId = $_GET['PID'];
    $dateTime = date('Y-m-d H:i:s');
    $username2 = $_SESSION['username'];
    $customerAddress = $_POST['address'];
    $customerPinCode = $_POST['pincode'];
    $customerMoNo = $_POST['phone'];
    $customerName = $_POST['name'];
    $paymentMode = $_POST['payment_mode'];
    $size = $_GET['SIZE']; // Retrieve the value from the query string parameter SIZE

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO ProductDeliveryTbl (ProductId, DateTime, UserName, CustomerAddress, CustomerPinCode, CustomerMoNo, CustomerName, PaymentMode, Size) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $productId, $dateTime, $username2, $customerAddress, $customerPinCode, $customerMoNo, $customerName, $paymentMode, $size);

    // Execute the statement
    if ($stmt->execute()) {
        $successMessage = "Data inserted successfully.";
    } else {
        $errorMessage = "Error inserting data.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }

        body {
            background-color: white;
        }

        .payment-form {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
        }

        .payment-form h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control,
        .btn {
            border-radius: 0;
        }

        .btn-primary {
            background-color: #000035;
            border-color: #000035;
        }

        .btn-primary:hover {
            background-color: #0066cc;
            border-color: #0066cc;
        }

        .alert-success {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<div class="sticky-top" style="z-index: 7;">
        <?php
include 'Header.php';
?></div>
    <div class="mt-4">
        <div class="card my-4 payment-form">
            <div class="card-header">
                <h4>Payment Details</h4>
            </div>

            <div class="card-body">
                <?php if (isset($errorMessage)) { ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php } ?>
                <?php if (isset($successMessage)) { ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php } ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?PID=' . $_GET['PID'] . '&SIZE=' . $_GET['SIZE']; ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="pincode">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_mode">Payment Mode</label>
                        <select class="form-control" id="payment_mode" name="payment_mode" required>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Net Banking">Net Banking</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Make Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="sticky-top" style="z-index: 7;">
        <?php
include 'Footer.php';
?></div>
</body>

</html>
