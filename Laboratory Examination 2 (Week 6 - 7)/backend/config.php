<?php

define('DB_PATH', __DIR__ . '/../database/abstrackgym.db');

function getDBConnection() {
    try {
        $dbDir = dirname(DB_PATH);
        if (!file_exists($dbDir)) {
            mkdir($dbDir, 0755, true);
        }
        
        $conn = new PDO('sqlite:' . DB_PATH);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $conn->exec('PRAGMA foreign_keys = ON;');
        
        return $conn;
    } catch (PDOException $e) {
        error_log("Database Connection Failed: " . $e->getMessage());
        die("Connection failed. Please try again later.");
    }
}

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
