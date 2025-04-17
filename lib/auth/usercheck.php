<?php
// Start session
session_start();

// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Check if user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo "<h2>User is logged in</h2>";
    echo "<p>User ID: " . $_SESSION["id"] . "</p>";
    echo "<p>Username: " . $_SESSION["username"] . "</p>";
    echo "<p>User Type: " . $_SESSION["user_type"] . "</p>";
    
    // Check user in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(":id", $_SESSION["id"]);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<h3>User found in database</h3>";
        echo "<p>Email: " . $user["email"] . "</p>";
        echo "<p>Company Name: " . $user["company_name"] . "</p>";
        echo "<p>Industry: " . $user["industry"] . "</p>";
        echo "<p>Total Points: " . $user["total_points"] . "</p>";
        echo "<p>Created: " . $user["created_at"] . "</p>";
    } else {
        echo "<h3>Error: User not found in database!</h3>";
    }
    
    echo "<p><a href='../../logout.php'>Logout</a></p>";
} else {
    echo "<h2>User is not logged in</h2>";
    echo "<p><a href='../../login.php'>Login</a></p>";
}
?> 