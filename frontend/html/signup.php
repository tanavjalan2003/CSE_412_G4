<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <section class="signup">
        <div class="auth-container">
            <div class="auth-form">
                <h1>Sign up</h1>
                <form id="signupForm" action="includes/signup.inc.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" id="userPassword" name="userPassword" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your password" required>
                    </div>
                    <button type="submit" class="view-btn">Sign up</button>
                </form>
                <p>Have an account?<a href="login.php">Login</a></p>
            </div>
        </div>
    </section>
</body>
</html>