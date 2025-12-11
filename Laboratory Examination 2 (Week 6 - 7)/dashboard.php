<?php
session_start();

// Check if user is logged in
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-image: linear-gradient(135deg, rgba(255, 235, 59, 0.55) 0%, rgba(139, 195, 74, 0.55) 100%), url('img/luwid.jpg'), url('img/troy.JPG');
            background-position: center center, left center, right center;
            background-size: cover, 50% 100%, 50% 100%;
            background-repeat: no-repeat, no-repeat, no-repeat;
            background-attachment: fixed, fixed, fixed;
        }
        
        .dashboard-container {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.98);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            text-align: center;
            opacity: 0.75;
        }
        
        h1 {
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        
        .user-info {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
        }
        
        .user-info p {
            margin: 10px 0;
            color: #4b5563;
        }
        
        .user-info strong {
            color: #1a1a1a;
        }
        
        .logout-btn {
            display: inline-block;
            padding: 14px 30px;
            background: #f59e0b;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
            opacity: 1;
        }
        
        .logout-btn:hover {
            background: #d97706;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .success-icon svg {
            width: 50px;
            height: 50px;
            stroke: white;
            stroke-width: 3;
            fill: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1>Welcome to CCE Skills Clinic!</h1>
        <p style="color: #6b7280; margin-bottom: 30px;">You have successfully logged in.</p>
        
        <div class="user-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($userName); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
        </div>
        
        <a href="backend/logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
