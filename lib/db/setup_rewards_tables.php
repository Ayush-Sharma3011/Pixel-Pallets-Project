<?php
/**
 * Setup Rewards System Database Tables
 * 
 * This script creates all necessary tables for the rewards system if they don't already exist:
 * - rewards: Stores available rewards that users can redeem
 * - reward_redemptions: Stores history of reward redemptions by users
 */

// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

try {
    // Check if tables already exist
    $tableExists = $conn->query("SHOW TABLES LIKE 'rewards'")->rowCount() > 0;
    
    if (!$tableExists) {
        echo "Creating rewards tables...<br>";
        
        // Create rewards table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS rewards (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                points_required INT NOT NULL,
                user_type ENUM('all', 'startup', 'corporate') DEFAULT 'all',
                category VARCHAR(100) NOT NULL,
                quantity INT NULL,
                image_url VARCHAR(255) NULL,
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");
        echo "- Rewards table created<br>";
        
        // Create reward redemptions table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS reward_redemptions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                reward_id INT NOT NULL,
                points_spent INT NOT NULL,
                redemption_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
                completion_date TIMESTAMP NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (reward_id) REFERENCES rewards(id) ON DELETE CASCADE
            )
        ");
        echo "- Reward redemptions table created<br>";
        
        // Insert sample rewards
        $rewards = [
            [
                'title' => 'Premium Account Upgrade',
                'description' => 'Upgrade to a premium account for 3 months. Enjoy enhanced features, priority matching, and dedicated support.',
                'points_required' => 1000,
                'user_type' => 'all',
                'category' => 'Account Upgrades',
                'quantity' => null
            ],
            [
                'title' => 'Featured Listing',
                'description' => 'Get your profile featured at the top of search results for 1 week. Increase your visibility to potential partners.',
                'points_required' => 500,
                'user_type' => 'all',
                'category' => 'Visibility Boosts',
                'quantity' => null
            ],
            [
                'title' => 'Business Strategy Consultation',
                'description' => 'One-hour consultation with a business strategy expert. Gain insights on growth, partnerships, and market positioning.',
                'points_required' => 2000,
                'user_type' => 'startup',
                'category' => 'Consultations',
                'quantity' => 10
            ],
            [
                'title' => 'Innovation Workshop Access',
                'description' => 'Gain access to our exclusive online innovation workshop. Learn cutting-edge methodologies and frameworks.',
                'points_required' => 1500,
                'user_type' => 'corporate',
                'category' => 'Events',
                'quantity' => 20
            ],
            [
                'title' => '$50 Amazon Gift Card',
                'description' => 'Redeem your points for a $50 Amazon Gift Card. Use it for business supplies or personal treats.',
                'points_required' => 5000,
                'user_type' => 'all',
                'category' => 'Gift Cards',
                'quantity' => 5
            ],
            [
                'title' => 'Press Release Distribution',
                'description' => 'We\'ll distribute your press release to our network of media partners. Ideal for announcing new products or partnerships.',
                'points_required' => 3000,
                'user_type' => 'all',
                'category' => 'Marketing',
                'quantity' => 8
            ],
            [
                'title' => 'LinkedIn Premium (1 Month)',
                'description' => 'Receive a code for one month of LinkedIn Premium. Enhance your networking capabilities and insights.',
                'points_required' => 2500,
                'user_type' => 'all',
                'category' => 'Subscriptions',
                'quantity' => 15
            ],
            [
                'title' => 'Startup Conference Ticket',
                'description' => 'One ticket to our annual startup conference. Network with investors, partners, and industry leaders.',
                'points_required' => 7500,
                'user_type' => 'startup',
                'category' => 'Events',
                'quantity' => 3
            ],
            [
                'title' => 'Corporate Innovation Toolkit',
                'description' => 'Digital toolkit with templates, frameworks, and resources to enhance your innovation processes.',
                'points_required' => 1200,
                'user_type' => 'corporate',
                'category' => 'Resources',
                'quantity' => null
            ],
            [
                'title' => 'SEO Audit & Recommendations',
                'description' => 'Comprehensive SEO audit of your website with actionable recommendations to improve visibility.',
                'points_required' => 3500,
                'user_type' => 'all',
                'category' => 'Marketing',
                'quantity' => 5
            ],
            [
                'title' => 'Custom Logo Design',
                'description' => 'Professional logo design service with unlimited revisions. Elevate your brand identity.',
                'points_required' => 4000,
                'user_type' => 'startup',
                'category' => 'Design Services',
                'quantity' => 4
            ],
            [
                'title' => 'Corporate Innovation Report',
                'description' => 'Exclusive access to our annual corporate innovation report with trends, case studies, and forecasts.',
                'points_required' => 1800,
                'user_type' => 'corporate',
                'category' => 'Resources',
                'quantity' => null
            ]
        ];
        
        $stmt = $conn->prepare("
            INSERT INTO rewards (title, description, points_required, user_type, category, quantity)
            VALUES (:title, :description, :points_required, :user_type, :category, :quantity)
        ");
        
        foreach ($rewards as $reward) {
            $stmt->bindParam(':title', $reward['title']);
            $stmt->bindParam(':description', $reward['description']);
            $stmt->bindParam(':points_required', $reward['points_required']);
            $stmt->bindParam(':user_type', $reward['user_type']);
            $stmt->bindParam(':category', $reward['category']);
            $stmt->bindParam(':quantity', $reward['quantity'], PDO::PARAM_INT);
            $stmt->execute();
        }
        
        echo "- Sample rewards inserted<br>";
        echo "Rewards system setup complete!";
    } else {
        echo "Rewards tables already exist.";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?> 