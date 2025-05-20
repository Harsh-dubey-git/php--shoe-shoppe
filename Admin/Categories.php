<!DOCTYPE html>
<html>

<head>
    <title>Categories Interface</title>
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

        <h2>Manage Categories</h2>
        <div class="card">


            <div class="card-header">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName"
                            placeholder="Enter category name">
                        <input type="hidden" id="categoryId" name="categoryId">
                    </div>
                    <button type="submit" class="btn btn-primary" name="add">Add Category</button>
                    <button type="submit" class="btn btn-success" name="update">Update Category</button>
                </form>
            </div>
            <div class="card-body">




                <?php
                $servername = "localhost";
                $username = "root";
                $password = "NewPassword";
                $dbname = "ShoeStore";

                // Create a connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Add category
                if (isset($_POST['add'])) {
                    $categoryName = $_POST['categoryName'];

                    $sql = "INSERT INTO CategoriesTbl (CategoryName) VALUES ('$categoryName')";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Category added successfully</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error adding category: ' . $conn->error . '</div>';
                    }
                }

                // Update category
                if (isset($_POST['update'])) {
                    $categoryId = $_POST['categoryId'];
                    $categoryName = $_POST['categoryName'];

                    $sql = "UPDATE CategoriesTbl SET CategoryName = '$categoryName' WHERE CategoryId = $categoryId";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Category updated successfully</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error updating category: ' . $conn->error . '</div>';
                    }
                }

                // Delete category
                if (isset($_GET['delete'])) {
                    $categoryId = $_GET['delete'];

                    $sql = "DELETE FROM CategoriesTbl WHERE CategoryId = $categoryId";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Category deleted successfully</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error deleting category: ' . $conn->error . '</div>';
                    }
                }

                // Retrieve categories from the database
                $sql = "SELECT * FROM CategoriesTbl";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="table">';
                    echo '<thead><tr><th>Category ID</th><th>Category Name</th><th>Action</th></tr></thead>';
                    echo '<tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['CategoryId'] . '</td>';
                        echo '<td>' . $row['CategoryName'] . '</td>';
                        echo '<td>';
                        echo '<a href="?delete=' . $row['CategoryId'] . '" class="btn btn-sm btn-danger m-2">Delete</a>';
                        echo '<button class="btn btn-sm btn-primary btn-edit m-2" data-id="' . $row['CategoryId'] . '" data-name="' . $row['CategoryName'] . '">Edit</button>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No categories found.</p>';
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
            var categoryId = $(this).data('id');
            var categoryName = $(this).data('name');

            $('#categoryId').val(categoryId);
            $('#categoryName').val(categoryName);
        });
    </script>
</body>

</html>
