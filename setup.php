<?php
// Database Setup Script for Biz-Fusion

// Database Configuration
$host = "localhost";
$username = "root";
$password = "";

// Create Connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Biz-Fusion Database Setup</h2>";

// Read SQL File
$sql_contents = file_get_contents('backend/config/database.sql');

// Execute the SQL commands
if ($conn->multi_query($sql_contents)) {
    echo "<p>Database setup completed successfully! The database and all required tables have been created.</p>";
    echo "<p>You can now use the Biz-Fusion application.</p>";
    echo "<p><a href='index.php'>Go to Homepage</a></p>";
} else {
    echo "<p>Error setting up database: " . $conn->error . "</p>";
}

$conn->close();
?> 