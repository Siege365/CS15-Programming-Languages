<?php
/**
 * Database Configuration File
 * Using SQLite for simple, file-based database
 */

// SQLite database file path
define('DB_PATH', __DIR__ . '/../database/abstrackgym.db');

// Create database connection
function getDBConnection() {
    try {
        // Ensure database directory exists
        $dbDir = dirname(DB_PATH);
        if (!file_exists($dbDir)) {
            mkdir($dbDir, 0755, true);
        }
        
        // Create SQLite connection
        $conn = new PDO('sqlite:' . DB_PATH);
        
        // Set error mode to exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Enable foreign keys
        $conn->exec('PRAGMA foreign_keys = ON;');
        
        return $conn;
    } catch (PDOException $e) {
        error_log("Database Connection Failed: " . $e->getMessage());
        die("Connection failed. Please try again later.");
    }
}

// Create users table
function createUsersTable() {
    try {
        $conn = getDBConnection();
        
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT NOT NULL,
            last_name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            last_login DATETIME,
            status TEXT DEFAULT 'active' CHECK(status IN ('active', 'inactive'))
        )";
        
        $conn->exec($sql);
        
        // Create index on email for faster lookups
        $conn->exec("CREATE INDEX IF NOT EXISTS idx_email ON users(email)");
        $conn->exec("CREATE INDEX IF NOT EXISTS idx_status ON users(status)");
        
        echo "Users table created successfully or already exists\n";
        
        return true;
    } catch (PDOException $e) {
        echo "Error creating users table: " . $e->getMessage() . "\n";
        return false;
    }
}
?>
