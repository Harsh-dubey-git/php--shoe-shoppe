<!DOCTYPE html>
<html>

<head>
    <title>Deliveries Interface</title>
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
    <div class="container">

        <h2>Manage Deliveries</h2>
        <div class="">
            <div class="card-body">
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

                // Retrieve deliveries from the database
                $sql = "SELECT * FROM ProductDeliveryTbl";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="table">';
                    echo '<thead><tr><th>Delivery ID</th><th>Product ID</th><th>Date & Time</th><th>User Name</th><th>Customer Address</th><th>Customer Pin Code</th><th>Customer Mobile No</th><th>Customer Name</th><th>Payment Mode</th><th>Status</th></tr></thead>';
                    echo '<tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['DeliveryId'] . '</td>';
                        echo '<td>' . $row['ProductId'] . '</td>';
                        echo '<td>' . $row['DateTime'] . '</td>';
                        echo '<td>' . $row['UserName'] . '</td>';
                        echo '<td>' . $row['CustomerAddress'] . '</td>';
                        echo '<td>' . $row['CustomerPinCode'] . '</td>';
                        echo '<td>' . $row['CustomerMoNo'] . '</td>';
                        echo '<td>' . $row['CustomerName'] . '</td>';
                        echo '<td>' . $row['PaymentMode'] . '</td>';
                        echo "<td><button class='btn btn-success btn-sm rounded-pill'>Confirm</button></td>";

                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No deliveries found.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>
