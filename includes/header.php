<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'My PHP App' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="/public/assets/css/style.css"> -->
     <!-- Lucide Icons -->
     <script src="https://unpkg.com/lucide@latest"></script>
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
        .sidebar a {
            color: white;
            font-size: 18px;
            text-decoration: none;
            margin: 15px 0;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
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
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body style="font-family: 'Inter', sans-serif;">
