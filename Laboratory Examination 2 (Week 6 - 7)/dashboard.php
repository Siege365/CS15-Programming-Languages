<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: template/login.php");
    exit();
}

$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User';
$userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CCE SKILLS CLINIC</title>
    <link rel="stylesheet" href="template/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1>Welcome to CCE Skills Clinic!</h1>
        <p class="welcome-text">You have successfully logged in.</p>
        
        <div class="user-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($userName); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
        </div>
        
        <a href="backend/logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
