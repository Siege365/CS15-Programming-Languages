<?php
session_start();
require_once 'config.php';

// Initialize response
$errors = [];
$success = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../template/register.php");
    exit();
}

// Sanitize and validate input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    // Remove all non-numeric characters for validation
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($cleanPhone) >= 10;
}

function validateName($name) {
    return strlen(trim($name)) >= 2 && preg_match("/^[a-zA-Z\s'-]+$/", $name);
}

// Get and sanitize POST data
$firstName = isset($_POST['first_name']) ? sanitizeInput($_POST['first_name']) : '';
$lastName = isset($_POST['last_name']) ? sanitizeInput($_POST['last_name']) : '';
$email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validation
if (empty($firstName)) {
    $errors[] = "First name is required";
} elseif (!validateName($firstName)) {
    $errors[] = "First name must be at least 2 characters and contain only letters";
}

if (empty($lastName)) {
    $errors[] = "Last name is required";
} elseif (!validateName($lastName)) {
    $errors[] = "Last name must be at least 2 characters and contain only letters";
}

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!validateEmail($email)) {
    $errors[] = "Invalid email format";
}

if (empty($password)) {
    $errors[] = "Password is required";
} elseif (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

// If there are validation errors, redirect back
if (!empty($errors)) {
    $_SESSION['error'] = implode(". ", $errors);
    header("Location: ../template/register.php");
    exit();
}

try {
    // Get database connection
    $conn = getDBConnection();
    
    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    
    if (!$checkStmt) {
        throw new Exception("Database error");
    }
    
    $checkStmt->execute([$email]);
    $existingUser = $checkStmt->fetch();
    
    if ($existingUser) {
        $_SESSION['error'] = "An account with this email already exists";
        header("Location: ../template/register.php");
        exit();
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL statement to insert new user
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Database error");
    }
    
    if ($stmt->execute([$firstName, $lastName, $email, $hashedPassword])) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: ../template/login.php");
        exit();
    } else {
        throw new Exception("Failed to create account");
    }
    
} catch (Exception $e) {
    // Log error (in production, use proper error logging)
    error_log("Registration Error: " . $e->getMessage());
    
    $_SESSION['error'] = "An error occurred during registration. Please try again.";
    header("Location: ../template/register.php");
    exit();
}
?>
