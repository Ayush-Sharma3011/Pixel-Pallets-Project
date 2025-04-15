<?php
// Display PHP information and check database connection
echo "<h1>PHP Environment Test</h1>";

// Check PHP version
echo "<h2>PHP Version</h2>";
echo "PHP Version: " . phpversion();

// Check if necessary PHP extensions are installed
echo "<h2>PHP Extensions</h2>";
$required_extensions = ['mysqli', 'pdo', 'pdo_mysql', 'session'];
foreach ($required_extensions as $ext) {
    echo $ext . ": " . (extension_loaded($ext) ? "Installed" : "Not Installed") . "<br>";
}

// Check database connection
echo "<h2>Database Connection Test</h2>";
try {
    require_once "backend/config/database.php";
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "Database Connection: Success";
        
        // Try to query the database
        $query = "SHOW TABLES";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        echo "<h3>Database Tables</h3>";
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . $row['Tables_in_' . $database->db_name] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Database Connection: Failed";
    }
} catch (Exception $e) {
    echo "Database Connection Error: " . $e->getMessage();
}

// Display file and directory structure
echo "<h2>Directory Structure</h2>";
function listDirectory($dir, $level = 0) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        echo str_repeat('&nbsp;&nbsp;', $level) . "- " . $file;
        if (is_dir($dir . '/' . $file)) {
            echo " (Directory)";
        }
        echo "<br>";
        if (is_dir($dir . '/' . $file)) {
            listDirectory($dir . '/' . $file, $level + 1);
        }
    }
}

listDirectory('.');
?> 