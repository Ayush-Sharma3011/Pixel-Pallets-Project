<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

// Include database connection
require_once '../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

echo "<h2>Connection Status</h2>";
if ($conn) {
    echo "<p style='color:green'>Database connection successful!</p>";
} else {
    echo "<p style='color:red'>Database connection failed!</p>";
    exit;
}

// Check if tables exist
echo "<h2>Tables Check</h2>";
$tables = ['users', 'startup_profiles', 'corporate_profiles', 'partnerships', 'messages'];
echo "<ul>";
foreach ($tables as $table) {
    try {
        $stmt = $conn->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->rowCount() > 0;
        echo "<li>$table: " . ($exists ? "<span style='color:green'>Exists</span>" : "<span style='color:red'>Does not exist</span>") . "</li>";
        
        if ($exists) {
            echo "<ul>";
            // Show table structure
            $stmt = $conn->query("DESCRIBE $table");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>{$row['Field']} ({$row['Type']})</li>";
            }
            echo "</ul>";
            
            // Show record count
            $stmt = $conn->query("SELECT COUNT(*) as count FROM $table");
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "<li>Record count: $count</li>";
        }
    } catch (PDOException $e) {
        echo "<li style='color:red'>Error checking $table: " . $e->getMessage() . "</li>";
    }
}
echo "</ul>";

// Test query for organizations
echo "<h2>Sample Organizations</h2>";
try {
    // Get startups
    $stmt = $conn->query("SELECT id, username, company_name, industry, user_type FROM users WHERE user_type = 'startup' LIMIT 5");
    $startups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($startups) > 0) {
        echo "<h3>Startups:</h3>";
        echo "<ul>";
        foreach ($startups as $startup) {
            echo "<li>ID: {$startup['id']}, Name: {$startup['company_name']}, Industry: {$startup['industry']}</li>";
            
            // Check for profile
            $stmt = $conn->prepare("SELECT * FROM startup_profiles WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $startup['id']);
            $stmt->execute();
            if ($profile = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<ul>";
                foreach ($profile as $key => $value) {
                    echo "<li>$key: $value</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color:orange'>No profile data found</p>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No startups found.</p>";
    }
    
    // Get corporates
    $stmt = $conn->query("SELECT id, username, company_name, industry, user_type FROM users WHERE user_type = 'corporate' LIMIT 5");
    $corporates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($corporates) > 0) {
        echo "<h3>Corporates:</h3>";
        echo "<ul>";
        foreach ($corporates as $corporate) {
            echo "<li>ID: {$corporate['id']}, Name: {$corporate['company_name']}, Industry: {$corporate['industry']}</li>";
            
            // Check for profile
            $stmt = $conn->prepare("SELECT * FROM corporate_profiles WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $corporate['id']);
            $stmt->execute();
            if ($profile = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<ul>";
                foreach ($profile as $key => $value) {
                    echo "<li>$key: $value</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color:orange'>No profile data found</p>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No corporates found.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>Error querying organizations: " . $e->getMessage() . "</p>";
}
?> 