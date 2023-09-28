<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <!-- Add your custom CSS for animations -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 100px;
        }

        h1 {
            font-size: 120px;
            color: #dc3545;
            transition: font-size 0.5s;
        }

        h1:hover {
            font-size: 120px;
        }

        /* Define the bounce animation */
        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }

        /* Apply the animation to the "404" text */
        h1 {
            font-size: 120px;
            color: #dc3545;
            animation: bounce 2s ease infinite;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12">
                <h1 class="display-4">404</h1>
                <p class="lead">Page Not Found</p>
                <p>We're sorry, but the page you're looking for doesn't exist.</p>
                <a href="home.php" class="btn btn-primary">Go Back to Home</a>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and your custom JS for animations -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>