<!DOCTYPE html>
<html>
<head>
    <title>Feedback Data</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>
<body>
<?php   $servername = "localhost";
                $username = "root";
                $password = "NewPassword";
                $dbname = "ShoeStore";

                // Create a connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
 ?>

    <div class="container mt-4">
        <h2>Feedback Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the database
                $conn = mysqli_connect('localhost', 'root', 'NewPassword', 'ShoeStore');
                if (!$conn) {
                    die("Database connection failed: " . mysqli_connect_error());
                }

                // Fetch data from the FeedbackTbl table
                $query = "SELECT * FROM FeedbackTbl";
                $result = mysqli_query($conn, $query);

                // Loop through the rows and display the data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "</tr>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
