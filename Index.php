<!DOCTYPE html>
<html>
<head>
    <title>ShoeStore</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Quicksand', sans-serif;
        }

        .navbar {
            background-color: #000035;
            color: white;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-nav .nav-item .nav-link {
            color: white;
        }

        .jumbotron {
            background-color: #000035;
            color: white;
            padding: 3rem;
        }

        .jumbotron h1 {
            font-size: 48px;
            font-weight: bold;
        }

        .jumbotron p {
            font-size: 18px;
        }

        .card {
            margin-bottom: 20px;
            border: none;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
        }

        .card-text {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-decoration-none d-flex justify-center allign-items-center text-light" href="Index.php"> <div class="d-flex mt-4 justify-content-center mb-0">
            <i data-lucide="volleyball"></i>            <h2>shoestore</h2>
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
                        <a class="nav-link btn btn-light rounded-4 bg-light text-dark" href="SignUp.php">SignUp</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron text-center" style="background-color: #000035;">
        <h1>Welcome to your footwear Shop</h1>
        <p>Find the latest electronics products and accessories.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="Assets/Adds/white-sandals-summer-footwear-fashion.jpg" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">Flip-Flops</h5>
                        <p class="card-text"> we provide the trendiest and most comfortable flip-flops! Find the perfect pair for your needs with stylish designs, comfortable features, and durable materials. Our knowledgeable staff will help you choose the right flip-flops, and we offer competitive prices and excellent service. Upgrade your footwear experience today at our Flip-Flop Shoppe!</p>                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Assets/Adds/irene-kredenets-dwKiHoqqxk8-unsplash.jpg" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">Sneakers</h5>
                        <p class="card-text">Welcome to our Sneaker Paradise! Step up your footwear game with our wide range of stylish sneakers. Our knowledgeable staff will help you find the perfect pair for your style and budget. Enjoy competitive prices and excellent service. Upgrade your shoe collection at our Sneaker Paradise today!</p>                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Assets/Adds/mohammad-metri-E-0ON3VGrBc-unsplash.jpg" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">High-Heels</h5>
                        <p class="card-text">Welcome to our High Heel Haven! Step up your style game with our collection of elegant and fashionable high heels. Our friendly staff will assist you in finding the perfect pair of high heels for any occasion. We offer competitive prices, exclusive deals, and excellent service. Upgrade your footwear collection at our High Heel Haven today!</p>                    </div>
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

          <script>
        lucide.createIcons();
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
