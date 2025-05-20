<?php
session_start();

// Check if the user is already logged in, redirect to home page


// Database connection settings
$servername = "localhost";
$username = "root";
$password = "NewPassword";
$dbname = "ShoeStore";

// Initialize form data variables
$name = "";
$email = "";
$message = "";

// Process the feedback form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate form data (you can add more validation if needed)
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Name, email, and message are required.";
    } else {
        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the insert statement
        $stmt = $conn->prepare("INSERT INTO FeedbackTbl (Name, Email, Message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Display success message
        $success = "Thank you for your feedback!";

        // Clear form data
        $name = "";
        $email = "";
        $message = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        .feedback-form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .feedback-form h2 {
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

        .success-message {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="sticky-top" style="z-index: 7;">
        <?php
        include 'Header.php';
        ?>
    </div>
<div class="container">
    <div class="feedback-form shadow mt-4">
        <h2>Feedback</h2>
        <?php if (isset($success)) { ?>
            <div class="alert alert-success success-message"><?php echo $success; ?></div>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required><?php echo $message; ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="sticky-top" style="z-index: 7;">
        <?php
include 'Footer.php';
?></div>
</body>
</html>
