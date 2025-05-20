<?php
session_start();

// Check if the user is already logged in, redirect to home page
if (isset($_SESSION['username'])) {
    header("Location: ./User/Store.php");
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ShoeStore";

// Process the signup form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username2 = $_POST['username'];
    $password2 = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $user_type = "USER"; // Set the default user type to "USER"

    // Validate form data (you can add more validation if needed)
    if (empty($username2) || empty($password2) || empty($confirm_password) || empty($email)) {
        $error = "All fields are required.";
    } elseif ($password2 !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the insert statement
        $stmt = $conn->prepare("INSERT INTO UserDataTbl (UserName, Password, ConfirmPassword, UserType, Email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username2, $password2, $confirm_password, $user_type, $email);

        // Execute the statement and check if the data is inserted successfully
        if ($stmt->execute()) {
            // Data insertion successful
            $_SESSION['username'] = $username2; // Start the session with the username
            header("Location: ./User/Store.php"); // Redirect to the home page or wherever you want to go after signup
            exit;
        } else {
            // Data insertion failed
            $error = "Error occurred. Please try again later.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }
        body {
            background-color: white;
        }
        
        .signup-form {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
        }
        
        .signup-form h2 {
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
            background-color: rgb(215, 140, 1);
            border-color: rgb(215, 140, 1);
        }
        
        .signup-link {
            text-align: center;
            display: block;
        }
        
        .signup-link a {
            color: #000035;
        }
        
        .signup-link a:hover {
            color: rgb(215, 140, 1);
        }
    </style>
</head>
<body>  
    <nav class="navbar navbar-expand-lg " style="background-color: #000035;">
        <div class="container">
            <a class="navbar-brand text-decoration-none text-light" href="Index.php"> <div class="d-flex justify-content-center mb-0">
            <img src="./Assets/logo.png" class="mx-2" height="50" width="50" />
            <h2>shoestore</h2>
        </div></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="Index.php">Home</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="SignIn.php">SignIn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light bg-light rounded-4" href="SignUp.php">SignUp</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="mt-4 pt-2">
        
        <div class="card shadow my-4 signup-form">
            <div class="card-header">
                <h4>Sign Up</h2>
            </div>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </div>
                </form>
                <div class="signup-link">
                    Already have an account? <a href="SignIn.php">Log in</a>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-top" style="z-index: 7;">
        <footer style="background-color: #000035;color: white;">
            <div class="container text-center p-4" >
              <div class="row">
                <div class="col-md-4">
                  <h4>About Us</h4>
                  <p>we a online footwear store.</p>
                </div>
                <div class="col-md-4">
                  <h4>Contact Information</h4>
                  <p>Email: info@shoestore.com</p>
                  <p>Phone: 123-456-7890</p>
                </div>
                <div class="col-md-4">
                  <h4>Follow Us</h4>
                  <div class="social-icons my-4">
                    <a href="#" target="_blank"><img src="Assets/Icons/facebook.png" height="25" width="25"></a>
                    <a href="#" target="_blank"><img src="Assets/Icons/twitter.png" height="25" width="25"></a>
                    <a href="#" target="_blank"><img src="Assets/Icons/instagram.png" height="25" width="25"></a>
                    <a href="#" target="_blank"><img src="Assets/Icons/whatsapp.png" height="25" width="25"></a>
                  </div>
                </div>
              </div>
              <hr>
              <p>&copy; 2023 ShoeStore. All rights reserved. | Designed with <span class="text-danger">&hearts;</span> by <a href="https://www.yourwebsitename.com" class="text-light">ShoeStore.com</a></p>
            </div>
          </footer></div></body>
</html>
