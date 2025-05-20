<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../SignIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }

        .category-icon {
            height: 32px;
            width: 32px;
            margin-bottom: 0.25rem;
        }

        .category-item p {
            margin: 0;
            font-size: 0.9rem;
        }

        .navbar-brand h2 {
            font-size: 1.5rem;
            margin: 0;
        }

        .btn-logout {
            background-color: #f8f9fa;
            border: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #e2e6ea;
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <div class="sticky-top shadow" style="background-color: #000035; z-index: 4000;">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="Store.php">
                <i data-lucide="volleyball"></i>                    <h2 class="text-light mb-0">shoestore</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                    <ul class="navbar-nav align-items-center">
                        <?php if (isset($_SESSION["username"])): ?>
                            <li class="nav-item mx-2">
                                <span class="nav-link text-light d-flex align-items-center">
                                    <i data-lucide="user" class="me-2"></i> <?= $_SESSION["username"]; ?>
                                </span>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item mx-2">
                            <a class="nav-link text-light" href="Cart.php">
                                <i data-lucide="shopping-cart" class="category-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-light" href="Feedback.php">
                                <i data-lucide="calendar" class="category-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item mx-2">
                            <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                                <button type="submit" name="logout" class="btn btn-logout text-light border border-light rounded-pill px-3">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

   

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
