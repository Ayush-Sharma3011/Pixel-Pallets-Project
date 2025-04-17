<?php
// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Include rewards system
require_once 'RewardsSystem.php';
$rewardsSystem = new RewardsSystem($conn);

// Run setup
try {
    echo "<h2>Setting up Rewards System...</h2>";
    
    if ($rewardsSystem->setupRewardsTables()) {
        echo "<p style='color: green;'>Rewards tables created successfully!</p>";
        echo "<p>You can now <a href='index.php'>visit the Rewards Center</a>.</p>";
    } else {
        echo "<p style='color: red;'>Failed to create rewards tables.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?> 