<?php
require_once 'config.php';

// Create users table if it doesn't exist
$users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('startup', 'corporate') NOT NULL,
    total_points INT(11) NOT NULL DEFAULT 0,
    profile_completed TINYINT(1) NOT NULL DEFAULT 0,
    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($users_table) === FALSE) {
    die("Error creating users table: " . $conn->error);
}

// Create points_log table if it doesn't exist
$points_log_table = "CREATE TABLE IF NOT EXISTS points_log (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    points INT(11) NOT NULL,
    activity VARCHAR(255) NOT NULL,
    date_earned DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($points_log_table) === FALSE) {
    die("Error creating points_log table: " . $conn->error);
}

// Create user_badges table if it doesn't exist
$badges_table = "CREATE TABLE IF NOT EXISTS user_badges (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    badge_name VARCHAR(100) NOT NULL,
    badge_description VARCHAR(255) NOT NULL,
    date_earned DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($badges_table) === FALSE) {
    die("Error creating user_badges table: " . $conn->error);
}

// Create rewards table if it doesn't exist
$rewards_table = "CREATE TABLE IF NOT EXISTS rewards (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    points_required INT(11) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($rewards_table) === FALSE) {
    die("Error creating rewards table: " . $conn->error);
}

// Create user_rewards table if it doesn't exist
$user_rewards_table = "CREATE TABLE IF NOT EXISTS user_rewards (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    reward_id INT(11) NOT NULL,
    redeemed_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed') NOT NULL DEFAULT 'pending',
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reward_id) REFERENCES rewards(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($user_rewards_table) === FALSE) {
    die("Error creating user_rewards table: " . $conn->error);
}

// Insert some sample rewards
$sample_rewards = [
    ["Premium Profile Badge", "Get a premium badge on your profile to stand out to potential partners.", 200],
    ["Featured Listing", "Your startup/corporate profile will be featured on the homepage for 1 week.", 500],
    ["Priority Matching", "Get priority in the matching algorithm for 1 month.", 750],
    ["1-Hour Consultation", "One hour consultation with a business development expert.", 1000],
    ["VIP Event Access", "Access to exclusive networking events.", 1500]
];

$reward_stmt = $conn->prepare("INSERT INTO rewards (name, description, points_required) VALUES (?, ?, ?)");

foreach ($sample_rewards as $reward) {
    // Check if reward already exists
    $check = $conn->query("SELECT id FROM rewards WHERE name = '{$reward[0]}'");
    if ($check->num_rows == 0) {
        $reward_stmt->bind_param("ssi", $reward[0], $reward[1], $reward[2]);
        $reward_stmt->execute();
    }
}

echo "Database setup completed successfully!";
?> 