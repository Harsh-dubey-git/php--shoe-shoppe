<!DOCTYPE html>
<html>

<head>
    <title>Manage User Data</title>
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

        <h2>Manage User Data</h2>
        <div class="card">
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

                // Retrieve user data from the UserDataTbl table
                $sql = "SELECT * FROM UserDataTbl";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="table">';
                    echo '<thead><tr><th>User ID</th><th>User Name</th><th>Password</th><th>Confirm Password</th><th>User Type</th><th>Email</th></tr></thead>';
                    echo '<tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['UserId'] . '</td>';
                        echo '<td>' . $row['UserName'] . '</td>';
                        echo '<td>' . $row['Password'] . '</td>';
                        echo '<td>' . $row['ConfirmPassword'] . '</td>';
                        echo '<td>' . $row['UserType'] . '</td>';
                        echo '<td>' . $row['Email'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No user data found.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>
