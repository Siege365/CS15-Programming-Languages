<?php
session_start();
require_once 'config.php';

// Initialize response
$errors = [];
$success = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../template/login.php");
    exit();
}

// Sanitize and validate input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Get and sanitize POST data
$email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validation
if (empty($email)) {
    $errors[] = "Email is required";
}

if (empty($password)) {
    $errors[] = "Password is required";
}

if (!empty($email) && !validateEmail($email)) {
    $errors[] = "Invalid email format";
}

if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

// If there are validation errors, redirect back
if (!empty($errors)) {
    $_SESSION['error'] = implode(". ", $errors);
    header("Location: ../template/login.php");
    exit();
}

try {
    // Get database connection
    $conn = getDBConnection();
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, status FROM users WHERE email = ? LIMIT 1");
    
    if (!$stmt) {
        throw new Exception("Database error");
    }
    
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if user exists
    if (!$user) {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: ../template/login.php");
        exit();
    }
    
    // Check if account is active
    if ($user['status'] !== 'active') {
        $_SESSION['error'] = "Your account has been deactivated. Please contact support.";
        header("Location: ../template/login.php");
        exit();
    }
    
    // Verify password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: ../template/login.php");
        exit();
    }
    
    // Password is correct, create session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['logged_in'] = true;
    
    // Update last login time
    $updateStmt = $conn->prepare("UPDATE users SET last_login = datetime('now') WHERE id = ?");
    $updateStmt->execute([$user['id']]);
    
    // Redirect to dashboard
    header("Location: ../dashboard.php");
    exit();
    
} catch (Exception $e) {
    // Log error (in production, use proper error logging)
    error_log("Login Error: " . $e->getMessage());
    
    $_SESSION['error'] = "An error occurred during login. Please try again.";
    header("Location: ../template/login.php");
    exit();
}
?>
