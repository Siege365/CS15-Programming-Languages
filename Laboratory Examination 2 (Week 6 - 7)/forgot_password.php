<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Abstrack Fitness Gym</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-image">
            <img src="img/hero-1 1.png" alt="Fitness">
        </div>
        <div class="auth-form-container">
            <div class="auth-form">
                <div class="logo">
                    <img src="img/logo-login-and-register.svg" alt="Abstrack Fitness Gym">
                </div>
                <h2>Reset Your Password</h2>
                <p style="text-align: center; color: #6b7280; margin-bottom: 30px; font-size: 14px;">
                    Enter your email address and we'll send you instructions to reset your password.
                </p>

                <form action="backend/forgot_password_process.php" method="POST" id="forgotPasswordForm">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="hello@example.com"
                            required
                        >
                        <span class="error-text" id="emailError"></span>
                    </div>

                    <button type="submit" class="btn-submit">Send Reset Link</button>
                </form>

                <div class="auth-footer">
                    <p>Remember your password? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>
