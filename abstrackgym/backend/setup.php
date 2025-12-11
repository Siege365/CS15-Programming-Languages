<?php
/**
 * Database Setup Script
 * Run this file once to create the database and tables
 */

require_once 'config.php';

echo "Setting up SQLite database...\n\n";

// Create users table
if (createUsersTable()) {
    echo "\nDatabase setup completed successfully!\n";
    echo "Database location: " . DB_PATH . "\n";
    echo "You can now use the login and registration system.\n";
} else {
    echo "\nDatabase setup failed. Please check the errors above.\n";
}
?>
