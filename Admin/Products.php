<?php include '../config/database.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<style>
    *{
            font-family: 'Quicksand', sans-serif;
        }
</style>
</head>

<body>

    <div class="container m-4">
        <div class="card">
            <div class="card-header">
                <h2>Add Product</h2>
            </div>
            <div class="card-body">
                <?php
                if (isset($_POST['submit'])) {
                    $productName = $_POST['productName'];
                    $productPrice = $_POST['productPrice'];
                    $productSellingPrice = $_POST['productSellingPrice'];
                    $productStock = $_POST['productStock'];
                    $productDetails = $_POST['productDetails'];
                    $productDescription = $_POST['productDescription'];
                    $productHighlight1 = $_POST['productHighlight1'];
                    $productHighlight2 = $_POST['productHighlight2'];
                    $return30Days = $_POST['return30Days'];
                    $freeDelivery = $_POST['freeDelivery'];
                    $cashOnDelivery = $_POST['cashOnDelivery'];
                    $productBrand = $_POST['productBrand'];
                    $productCategory = $_POST['productCategory'];

                    // Insert the form data into the database
                    // Replace DB_CONNECTION with your actual database connection code
                    // $conn = new PDO("mysql:host=localhost;dbname=ShoeStore", "root", "NewPassword");
                    $query = $conn->prepare("INSERT INTO ProductDataTbl (ProductName, ProductPrice, ProductSellingPrice, ProductStock, ProductDetails, ProductDescription, ProductHighlight1, ProductHighlight2, 30DaysReturn, FreeDelivery, CashOnDelivery, BrandId, CategoryId) VALUES (:productName, :productPrice, :productSellingPrice, :productStock, :productDetails, :productDescription, :productHighlight1, :productHighlight2, :return30Days, :freeDelivery, :cashOnDelivery, :brandId, :categoryId)");
                    $query->bindParam(":productName", $productName);
                    $query->bindParam(":productPrice", $productPrice);
                    $query->bindParam(":productSellingPrice", $productSellingPrice);
                    $query->bindParam(":productStock", $productStock);
                    $query->bindParam(":productDetails", $productDetails);
                    $query->bindParam(":productDescription", $productDescription);
                    $query->bindParam(":productHighlight1", $productHighlight1);
                    $query->bindParam(":productHighlight2", $productHighlight2);
                    $query->bindParam(":return30Days", $return30Days);
                    $query->bindParam(":freeDelivery", $freeDelivery);
                    $query->bindParam(":cashOnDelivery", $cashOnDelivery);
                    $query->bindParam(":brandId", $productBrand);
                    $query->bindParam(":categoryId", $productCategory);
                    $success = $query->execute();

                    $productId = $conn->lastInsertId();

                    // Upload product images to the server and insert their data into the database
                    $targetDirectory = "../Assets/Products/";
                    $uploadedFiles = array();
                    foreach ($_FILES['productImages']['name'] as $key => $imageName) {
                        $imageTmpName = $_FILES['productImages']['tmp_name'][$key];
                        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                        $imageNewName = uniqid() . "." . $imageExtension;
                        $targetPath = $targetDirectory . $imageNewName;

                        if (move_uploaded_file($imageTmpName, $targetPath)) {
                            $uploadedFiles[] = $targetPath;
                            $imageQuery = $conn->prepare("INSERT INTO ProductImageTbl (ProductId, ImageName, ImageExtension) VALUES (:productId, :imageName, :imageExtension)");
                            $imageQuery->bindParam(":productId", $productId);
                            $imageQuery->bindParam(":imageName", $imageNewName);
                            $imageQuery->bindParam(":imageExtension", $imageExtension);
                            $imageQuery->execute();
                        }
                    }

                    if ($success) {
                        echo '<div class="alert alert-success">Product added successfully!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Failed to add the product. Please try again.</div>';
                    }
                }
                ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="productName">Product Name:</label>
                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name">
                    </div>
                    <!-- Rest of the form fields -->


<div class="row">
                    <div class="form-group col-4">
                        <label for="productPrice">Product Price:</label>
                        <input type="text" class="form-control" id="productPrice" name="productPrice" placeholder="Enter product price">
                    </div>
                    <div class="form-group col-4">
                        <label for="productSellingPrice">Product Selling Price:</label>
                        <input type="text" class="form-control" id="productSellingPrice" name="productSellingPrice" placeholder="Enter product selling price">
                    </div>
                    <div class="form-group col-4">
                        <label for="productStock">Product Stock:</label>
                        <input type="text" class="form-control" id="productStock" name="productStock" placeholder="Enter product stock">
                    </div>

                </div>
                    <div class="form-group">
                        <label for="productDetails">Product Details:</label>
                        <textarea class="form-control" id="productDetails" name="productDetails" rows="3" placeholder="Enter product details"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Product Description:</label>
                        <textarea class="form-control" id="productDescription" name="productDescription" rows="5" placeholder="Enter product description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productHighlight1">Product Highlight 1:</label>
                        <input type="text" class="form-control" id="productHighlight1" name="productHighlight1" placeholder="Enter product highlight 1">
                    </div>
                    <div class="form-group">
                        <label for="productHighlight2">Product Highlight 2:</label>
                        <input type="text" class="form-control" id="productHighlight2" name="productHighlight2" placeholder="Enter product highlight 2">
                    </div>


                    <div class="row">
                    <div class="form-group col-4">
                        <label for="return30Days">Return within 30 days:</label>
                        <select class="form-control" id="return30Days" name="return30Days">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="freeDelivery">Free Delivery:</label>
                        <select class="form-control" id="freeDelivery" name="freeDelivery">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="cashOnDelivery">Cash on Delivery:</label>
                        <select class="form-control" id="cashOnDelivery" name="cashOnDelivery">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                    <div class="row">
                    <div class="form-group col-6">
                        <label for="productBrand">Product Brand:</label>
                        <select class="form-control" id="productBrand" name="productBrand">
                            <?php
                            // Fetch brand data from the database and populate the dropdown options
                            // Replace DB_CONNECTION with your actual database connection code
                            // $conn = new PDO("mysql:host=localhost;dbname=ShoeStore", "root", "NewPassword");
                            $brandQuery = $conn->query("SELECT * FROM BrandsTbl");
                            while ($brand = $brandQuery->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $brand['BrandId'] . "'>" . $brand['BrandName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="productCategory">Product Category:</label>
                        <select class="form-control" id="productCategory" name="productCategory">
                            <?php
                            // Fetch category data from the database and populate the dropdown options
                            // Replace DB_CONNECTION with your actual database connection code
                            $categoryQuery = $conn->query("SELECT * FROM CategoriesTbl");
                            while ($category = $categoryQuery->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $category['CategoryId'] . "'>" . $category['CategoryName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                    <div class="row">
                    <div class="form-group col-6">
            <label for="productImages">Product Images:</label>
                <input type="file"  id="productImages" name="productImages[]" multiple>
        </div>
        <div class="form-group col-6">
            <label for="productImages2">Product Image 2:</label>
            
                <input type="file" id="productImages2" name="productImages[]" multiple>
            
        </div>
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label for="productImages3">Product Image 3:</label>
                <input type="file"  id="productImages3" name="productImages[]" multiple>
        </div>
        
        <div class="form-group col-6">
            <label for="productImages4">Product Image 4:</label>
                <input type="file" id="productImages4" name="productImages[]" multiple>
                
        </div>
    </div>       <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Display alerts using Bootstrap JavaScript
        $(document).ready(function() {
            $(".alert").alert();
        });
    </script>
</body>

</html>
