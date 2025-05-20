<?php
session_start();
require_once __DIR__ . '/../config/database.php'; 
function logout() {
    session_destroy();
    header("Location: ../SignIn.php");
    exit;
}

if (isset($_POST['logout'])) {
    logout();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
        }

        .sidebar {
            background-color: #000035;
            color: white;
            min-height: 100vh;
            padding-top: 30px;
        }

        .sidebar h3 {
            margin-left: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #005A9C;
        }

        .logout-btn {
            margin-top: auto;
            padding: 20px;
        }

        iframe {
            height: calc(100vh - 0px);
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-flex flex-column sidebar">
                <div class="d-flex align-items-center mb-4 ps-3  gap-2">
                    <h3 class="mb-0" style="  " >ShoeStore</h3>                    <i data-lucide="volleyball"></i>

                    </div>

                <nav class="flex-grow-1">
                    <a href="Dashboard.php" target="content"><i data-lucide="layout-dashboard"></i> Dashboard</a>
                    <a href="Products.php" target="content"><i data-lucide="box"></i> Products</a>
                    <a href="Deliveries.php" target="content"><i data-lucide="truck"></i> Orders</a>
                    <a href="UsersData.php" target="content"><i data-lucide="users"></i> Customers</a>
                    <a href="Brands.php" target="content"><i data-lucide="tag"></i> Brands</a>
                    <a href="Categories.php" target="content"><i data-lucide="layers"></i> Categories</a>
                    <a href="FeedbackData.php" target="content"><i data-lucide="message-circle"></i> Feedback</a>
                    <a href="Reports.php" target="content"><i data-lucide="file-text"></i> Reports</a>
                    <a href="Analysis.php" target="content"><i data-lucide="bar-chart-2"></i> Analysis</a>
                </nav>

                <div class="logout-btn">
                    <form method="post">
                        <button class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2" type="submit" name="logout">
                            <i data-lucide="log-out"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-0">
                <iframe name="content" class="w-100"></iframe>
            </div>
        </div>
    </div>

    <!-- Bootstrap & Lucide JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
