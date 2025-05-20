
<!DOCTYPE html>
<html>

<head>
    <title>Brands Interface</title>
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

        <h2>Manage Brands</h2>
        <div class="card">
            

            <div class="card-header">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="brandName">Brand Name:</label>
                        <input type="text" class="form-control" id="brandName" name="brandName"
                            placeholder="Enter brand name">
                        <input type="hidden" id="brandId" name="brandId">
                    </div>
                    <button type="submit" class="btn btn-primary" name="add">Add Brand</button>
                    <button type="submit" class="btn btn-success" name="update">Update Brand</button>
                </form>
            </div>
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

        // Add brand
        if (isset($_POST['add'])) {
            $brandName = $_POST['brandName'];

            $sql = "INSERT INTO BrandsTbl (BrandName) VALUES ('$brandName')";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success" role="alert">Brand added successfully</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error adding brand: ' . $conn->error . '</div>';
            }
        }

        // Update brand
        if (isset($_POST['update'])) {
            $brandId = $_POST['brandId'];
            $brandName = $_POST['brandName'];

            $sql = "UPDATE BrandsTbl SET BrandName = '$brandName' WHERE BrandId = $brandId";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success" role="alert">Brand updated successfully</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error updating brand: ' . $conn->error . '</div>';
            }
        }

        // Delete brand
        if (isset($_GET['delete'])) {
            $brandId = $_GET['delete'];

            $sql = "DELETE FROM BrandsTbl WHERE BrandId = $brandId";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success" role="alert">Brand deleted successfully</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error deleting brand: ' . $conn->error . '</div>';
            }
        }

        // Retrieve brands from the database
        $sql = "SELECT * FROM BrandsTbl";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead><tr><th>Brand ID</th><th>Brand Name</th><th>Action</th></tr></thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['BrandId'] . '</td>';
                echo '<td>' . $row['BrandName'] . '</td>';
                echo '<td>';
                echo '<a href="?delete=' . $row['BrandId'] . '" class="btn btn-sm btn-danger m-2">Delete</a>';
                echo '<button class="btn btn-sm btn-primary btn-edit m-2" data-id="' . $row['BrandId'] . '" data-name="' . $row['BrandName'] . '">Edit</button>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No brands found.</p>';
        }

        $conn->close();
        ?>

            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Edit button click event
        $('.btn-edit').click(function () {
            var brandId = $(this).data('id');
            var brandName = $(this).data('name');

            $('#brandId').val(brandId);
            $('#brandName').val(brandName);
        });
    </script>
</body>

</html>