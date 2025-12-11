<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit();
}

// Get error and success messages from session
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['error']);
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Abstrack Fitness Gym</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-form-container">
            <div class="auth-form register-form">
                <div class="logo">
                    <img src="../img/CCE.png" alt="CCE Logo">
                </div>
                <h2>Sign up your account</h2>
                
                <?php if ($error): ?>
                    <div class="error-message" id="errorMessage"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success-message" id="successMessage"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form action="../backend/register_process.php" method="POST" id="registerForm" novalidate>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input 
                                type="text" 
                                id="firstName" 
                                name="first_name" 
                                placeholder="John"
                                required
                            >
                            <span class="error-text" id="firstNameError"></span>
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input 
                                type="text" 
                                id="lastName" 
                                name="last_name" 
                                placeholder="Doe"
                                required
                            >
                            <span class="error-text" id="lastNameError"></span>
                        </div>
                    </div>

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

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="******"
                                required
                            >
                            <button type="button" class="toggle-password" id="togglePassword">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <span class="error-text" id="passwordError"></span>
                    </div>

                    <button type="submit" class="btn-submit">Sign me up</button>
                </form>

                <div class="auth-footer">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>
