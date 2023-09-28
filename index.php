<?php include('include/config.php') ?>

<?php

if (isset($_COOKIE['id']) && isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    header('location: home.php');
} else {

    if (isset($_POST['login'])) {

        $email = trim(htmlspecialchars(substr($_POST['email'], 0, 30)));
        $password = md5($_POST['password']);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? && password = ?");
        $stmt->execute([$email, $password]);

        if ($stmt->rowCount() == 1) {

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            $id = $row->id;

            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            setcookie('id', $id, time() + (86400 * 30), "/");
            setcookie('email', $email, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");

            header('location: home.php');
        }
    }

    if (isset($_POST['signup'])) {

        $name = trim(htmlspecialchars(substr($_POST['name'], 0, 30)));
        $email = trim(htmlspecialchars(substr($_POST['email'], 0, 30)));
        $password = md5($_POST['password']);


        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute([$name, $email, $password])) {

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? && password = ?");
            $stmt->execute([$email, $password]);

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            $id = $row->id;

            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            setcookie('id', $id, time() + (86400 * 30), "/");
            setcookie('email', $email, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");

            header('location: home.php');
        }

    }
    $pdo = null;

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Social Media Signup and Login</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <span class="nav-link active" id="action">Log In</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Login Form -->
                                <div class="tab-pane active" id="loginForm">
                                    <form method="post">
                                        <div class="mb-3">
                                            <label for="loginEmail" class="form-label">Email address</label>
                                            <input type="email" maxlength="30" name="email" class="form-control"
                                                id="loginEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="loginPassword"
                                                required>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary">Log In</button>
                                    </form>
                                    <p class="mt-3">
                                        Don't have an account? <span style="cursor: pointer;" class="text-primary"
                                            id="showSignupForm">Sign Up</span>
                                    </p>
                                </div>

                                <!-- Signup Form (Initially Hidden) -->
                                <div class="tab-pane" id="signupForm">
                                    <form method="post">
                                        <div class="mb-3">
                                            <label for="signupName" class="form-label">Full Name</label>
                                            <input type="text" maxlength="30" name="name" class="form-control"
                                                id="signupName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupEmail" class="form-label">Email address</label>
                                            <input type="email" maxlength="30" name="email" class="form-control"
                                                id="signupEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="signupPassword"
                                                required>
                                        </div>
                                        <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
                                    </form>
                                    <p class="mt-3">
                                        Already have an account? <span style="cursor: pointer;" class="text-primary"
                                            id="showLoginForm">Log In</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // JavaScript to toggle between login and signup forms
            document.getElementById('showSignupForm').addEventListener('click', function () {
                document.getElementById('loginForm').classList.remove('active');
                document.getElementById('signupForm').classList.add('active');
                document.getElementById('action').innerHTML = 'Sign Up';
            });

            document.getElementById('showLoginForm').addEventListener('click', function () {
                document.getElementById('signupForm').classList.remove('active');
                document.getElementById('loginForm').classList.add('active');
                document.getElementById('action').innerHTML = 'Login';
            });
        </script>
    </body>

    </html>

    <?php
}
?>