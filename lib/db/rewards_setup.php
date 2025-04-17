<?php
/**
 * Rewards System Database Setup
 * 
 * This script initializes the necessary database tables for the rewards system:
 * - rewards: Stores available rewards that users can redeem
 * - reward_redemptions: Stores history of reward redemptions by users
 */

// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Include RewardsSystem class
require_once '../rewards/RewardsSystem.php';
$rewardsSystem = new RewardsSystem($conn);

// Check if tables already exist
try {
    $stmt = $conn->prepare("SHOW TABLES LIKE 'rewards'");
    $stmt->execute();
    $rewardsTableExists = $stmt->rowCount() > 0;
    
    $stmt = $conn->prepare("SHOW TABLES LIKE 'reward_redemptions'");
    $stmt->execute();
    $redemptionsTableExists = $stmt->rowCount() > 0;
    
    if (!$rewardsTableExists || !$redemptionsTableExists) {
        // Setup rewards tables and add sample data
        $success = $rewardsSystem->setupRewardsTables();
        
        if ($success) {
            echo "Rewards system tables created successfully!";
        } else {
            echo "Error creating rewards system tables.";
        }
    } else {
        echo "Rewards system tables already exist.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?> 