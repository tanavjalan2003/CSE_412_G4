<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <section class="login">
            <div class="login-container">
                    <h1>Login</h1>
                    <form id="loginForm" action="includes/login.inc.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Password</label>
                            <input type="password" id="userPassword" name="userPassword" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" name="submit" class="view-btn">Login</button>
                    </form>
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
    </section>
</body>
</html>