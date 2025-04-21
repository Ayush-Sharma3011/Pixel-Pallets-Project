<?php
// Include database connection
require_once 'config/database.php';
$database = new Database();
$conn = $database->getConnection();

// SQL commands to create messages table and update partnerships table
$sql = "
-- Create messages table if it doesn't exist
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `partnership_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `partnership_id` (`partnership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Check if last_activity column exists in partnerships table
SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'bizfusion' 
AND TABLE_NAME = 'partnerships' 
AND COLUMN_NAME = 'last_activity';
";

try {
    // Execute the SQL to create messages table
    $conn->exec("CREATE TABLE IF NOT EXISTS `messages` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `sender_id` int(11) NOT NULL,
      `receiver_id` int(11) NOT NULL,
      `partnership_id` int(11) NOT NULL,
      `message` text NOT NULL,
      `is_read` tinyint(1) NOT NULL DEFAULT 0,
      `created_at` datetime NOT NULL,
      PRIMARY KEY (`id`),
      KEY `sender_id` (`sender_id`),
      KEY `receiver_id` (`receiver_id`),
      KEY `partnership_id` (`partnership_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    
    // Check if last_activity column exists
    $stmt = $conn->query("SELECT COUNT(*) as col_exists FROM INFORMATION_SCHEMA.COLUMNS 
                         WHERE TABLE_SCHEMA = 'bizfusion' 
                         AND TABLE_NAME = 'partnerships' 
                         AND COLUMN_NAME = 'last_activity'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Add last_activity column if it doesn't exist
    if ($result['col_exists'] == 0) {
        $conn->exec("ALTER TABLE `partnerships` ADD COLUMN `last_activity` datetime DEFAULT NULL AFTER `created_at`");
        echo "Added last_activity column to partnerships table.<br>";
    }
    
    // Check if initial_message column exists
    $stmt = $conn->query("SELECT COUNT(*) as col_exists FROM INFORMATION_SCHEMA.COLUMNS 
                         WHERE TABLE_SCHEMA = 'bizfusion' 
                         AND TABLE_NAME = 'partnerships' 
                         AND COLUMN_NAME = 'initial_message'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Add initial_message column if it doesn't exist
    if ($result['col_exists'] == 0) {
        $conn->exec("ALTER TABLE `partnerships` ADD COLUMN `initial_message` text DEFAULT NULL AFTER `last_activity`");
        echo "Added initial_message column to partnerships table.<br>";
    }
    
    // Create indexes on partnerships table
    $conn->exec("ALTER TABLE `partnerships` 
                ADD INDEX IF NOT EXISTS `idx_startup_id` (`startup_id`),
                ADD INDEX IF NOT EXISTS `idx_corporate_id` (`corporate_id`)");
    
    echo "Database updated successfully.<br>";
    echo "Messages table created and partnerships table updated with new columns.<br>";
    echo "<a href='../index.php'>Go back to homepage</a>";
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "<br>";
    echo "<a href='../index.php'>Go back to homepage</a>";
}
?> 