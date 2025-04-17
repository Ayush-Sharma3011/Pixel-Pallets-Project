<?php
/**
 * Rewards System Class
 * 
 * This class handles all functionality related to rewards management:
 * - Retrieving available rewards
 * - Redeeming rewards
 * - Managing user redemption history
 */

class RewardsSystem {
    private $conn;
    
    /**
     * Constructor
     * 
     * @param PDO $conn Database connection
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Get available rewards that can be redeemed by users
     * 
     * @param string $user_type The user type (startup, corporate, or all)
     * @param string $category Filter by reward category
     * @param string $sort Sort order (newest, oldest, points_asc, points_desc)
     * @param int $limit Number of results to return
     * @param int $offset Pagination offset
     * @return array Array of available rewards
     */
    public function getAvailableRewards($user_type = 'all', $category = 'all', $sort = 'newest', $limit = 12, $offset = 0) {
        $sql = "SELECT * FROM rewards WHERE status = 'active' AND ";
        $params = [];
        
        // Filter by user type
        if ($user_type != 'all') {
            $sql .= "(user_type = :user_type OR user_type = 'all') AND ";
            $params[':user_type'] = $user_type;
        }
        
        // Filter by category
        if ($category != 'all') {
            $sql .= "category = :category AND ";
            $params[':category'] = $category;
        }
        
        // Remove trailing "AND "
        $sql = rtrim($sql, "AND ");
        
        // Add sorting
        switch ($sort) {
            case 'oldest':
                $sql .= "ORDER BY created_at ASC";
                break;
            case 'points_asc':
                $sql .= "ORDER BY points_required ASC";
                break;
            case 'points_desc':
                $sql .= "ORDER BY points_required DESC";
                break;
            case 'newest':
            default:
                $sql .= "ORDER BY created_at DESC";
                break;
        }
        
        // Add pagination
        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $key => $value) {
            if ($key == ':limit' || $key == ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Count total number of available rewards (for pagination)
     * 
     * @param string $user_type The user type (startup, corporate, or all)
     * @param string $category Filter by reward category
     * @return int Total number of rewards matching the criteria
     */
    public function countAvailableRewards($user_type = 'all', $category = 'all') {
        $sql = "SELECT COUNT(*) FROM rewards WHERE status = 'active' AND ";
        $params = [];
        
        // Filter by user type
        if ($user_type != 'all') {
            $sql .= "(user_type = :user_type OR user_type = 'all') AND ";
            $params[':user_type'] = $user_type;
        }
        
        // Filter by category
        if ($category != 'all') {
            $sql .= "category = :category AND ";
            $params[':category'] = $category;
        }
        
        // Remove trailing "AND "
        $sql = rtrim($sql, "AND ");
        
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    /**
     * Get all reward categories
     * 
     * @return array Array of distinct reward categories
     */
    public function getRewardCategories() {
        $stmt = $this->conn->prepare("SELECT DISTINCT category FROM rewards WHERE status = 'active' ORDER BY category");
        $stmt->execute();
        $categories = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row['category'];
        }
        
        return $categories;
    }
    
    /**
     * Get a specific reward by ID
     * 
     * @param int $reward_id The reward ID
     * @return array|bool Reward data or false if not found
     */
    public function getRewardById($reward_id) {
        $stmt = $this->conn->prepare("SELECT * FROM rewards WHERE id = :id");
        $stmt->bindParam(":id", $reward_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Redeem a reward for a user
     * 
     * @param int $user_id The user ID
     * @param int $reward_id The reward ID
     * @param int $points_cost The points cost of the reward
     * @return int|bool Redemption ID if successful, false otherwise
     */
    public function redeemReward($user_id, $reward_id, $points_cost) {
        // Start transaction
        $this->conn->beginTransaction();
        
        try {
            // Get the reward to confirm it exists and is active
            $stmt = $this->conn->prepare("SELECT * FROM rewards WHERE id = :reward_id AND status = 'active'");
            $stmt->bindParam(":reward_id", $reward_id, PDO::PARAM_INT);
            $stmt->execute();
            $reward = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$reward) {
                throw new Exception("Reward not found or is inactive");
            }
            
            // Check if user has enough points
            $stmt = $this->conn->prepare("SELECT total_points FROM users WHERE id = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user || $user['total_points'] < $points_cost) {
                throw new Exception("Not enough points");
            }
            
            // Check quantity if applicable
            if ($reward['quantity'] !== null && $reward['quantity'] <= 0) {
                throw new Exception("This reward is out of stock");
            }
            
            // Deduct points from user
            $stmt = $this->conn->prepare("UPDATE users SET total_points = total_points - :points_cost WHERE id = :user_id");
            $stmt->bindParam(":points_cost", $points_cost, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Update quantity if applicable
            if ($reward['quantity'] !== null) {
                $stmt = $this->conn->prepare("UPDATE rewards SET quantity = quantity - 1 WHERE id = :reward_id");
                $stmt->bindParam(":reward_id", $reward_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            // Record the redemption
            $stmt = $this->conn->prepare("
                INSERT INTO reward_redemptions (user_id, reward_id, points_spent, redemption_date, status) 
                VALUES (:user_id, :reward_id, :points_spent, NOW(), 'pending')
            ");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":reward_id", $reward_id, PDO::PARAM_INT);
            $stmt->bindParam(":points_spent", $points_cost, PDO::PARAM_INT);
            $stmt->execute();
            
            $redemption_id = $this->conn->lastInsertId();
            
            // Record points transaction
            $stmt = $this->conn->prepare("
                INSERT INTO points_transactions (user_id, points, activity, created_at) 
                VALUES (:user_id, :points, :activity, NOW())
            ");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindValue(":points", -$points_cost, PDO::PARAM_INT);
            $stmt->bindValue(":activity", "Redeemed reward: " . $reward['title'], PDO::PARAM_STR);
            $stmt->execute();
            
            // Commit transaction
            $this->conn->commit();
            
            return $redemption_id;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    /**
     * Get a user's redemption history
     * 
     * @param int $user_id The user ID
     * @param int $limit Number of results to return
     * @param int $offset Pagination offset
     * @return array Array of redemption history
     */
    public function getUserRedemptionHistory($user_id, $limit = 10, $offset = 0) {
        $stmt = $this->conn->prepare("
            SELECT r.*, rw.title 
            FROM reward_redemptions r
            JOIN rewards rw ON r.reward_id = rw.id
            WHERE r.user_id = :user_id
            ORDER BY r.redemption_date DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Count total number of user redemptions (for pagination)
     * 
     * @param int $user_id The user ID
     * @return int Total number of redemptions
     */
    public function countUserRedemptions($user_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM reward_redemptions WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    
    /**
     * Get a specific redemption by ID
     * 
     * @param int $redemption_id The redemption ID
     * @return array|bool Redemption data or false if not found
     */
    public function getRedemptionById($redemption_id) {
        $stmt = $this->conn->prepare("SELECT * FROM reward_redemptions WHERE id = :id");
        $stmt->bindParam(":id", $redemption_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Cancel a pending redemption and refund points
     * 
     * @param int $redemption_id The redemption ID
     * @return bool True if successful, false otherwise
     */
    public function cancelRedemption($redemption_id) {
        // Start transaction
        $this->conn->beginTransaction();
        
        try {
            // Get the redemption to confirm it exists and is pending
            $stmt = $this->conn->prepare("SELECT * FROM reward_redemptions WHERE id = :id AND status = 'pending'");
            $stmt->bindParam(":id", $redemption_id, PDO::PARAM_INT);
            $stmt->execute();
            $redemption = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$redemption) {
                throw new Exception("Redemption not found or cannot be cancelled");
            }
            
            // Get reward information
            $stmt = $this->conn->prepare("SELECT * FROM rewards WHERE id = :reward_id");
            $stmt->bindParam(":reward_id", $redemption['reward_id'], PDO::PARAM_INT);
            $stmt->execute();
            $reward = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$reward) {
                throw new Exception("Reward not found");
            }
            
            // Update redemption status to cancelled
            $stmt = $this->conn->prepare("UPDATE reward_redemptions SET status = 'cancelled' WHERE id = :id");
            $stmt->bindParam(":id", $redemption_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Refund points to user
            $stmt = $this->conn->prepare("UPDATE users SET total_points = total_points + :points WHERE id = :user_id");
            $stmt->bindParam(":points", $redemption['points_spent'], PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $redemption['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            
            // Increase reward quantity if applicable
            if ($reward['quantity'] !== null) {
                $stmt = $this->conn->prepare("UPDATE rewards SET quantity = quantity + 1 WHERE id = :reward_id");
                $stmt->bindParam(":reward_id", $redemption['reward_id'], PDO::PARAM_INT);
                $stmt->execute();
            }
            
            // Record points refund transaction
            $stmt = $this->conn->prepare("
                INSERT INTO points_transactions (user_id, points, activity, created_at) 
                VALUES (:user_id, :points, :activity, NOW())
            ");
            $stmt->bindParam(":user_id", $redemption['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(":points", $redemption['points_spent'], PDO::PARAM_INT);
            $stmt->bindValue(":activity", "Refund for cancelled redemption: " . $reward['title'], PDO::PARAM_STR);
            $stmt->execute();
            
            // Commit transaction
            $this->conn->commit();
            
            return true;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    /**
     * Setup rewards database tables
     * 
     * @return bool True if successful
     */
    public function setupRewardsTables() {
        try {
            // Create rewards table
            $this->conn->exec("
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ");
            
            // Create redemptions table
            $this->conn->exec("
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ");
            
            // Check if points_transactions table exists, if not create it
            $stmt = $this->conn->prepare("SHOW TABLES LIKE 'points_transactions'");
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $this->conn->exec("
                    CREATE TABLE IF NOT EXISTS points_transactions (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        user_id INT NOT NULL,
                        points INT NOT NULL,
                        activity VARCHAR(255) NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
                ");
            }
            
            // Add sample rewards
            $this->addSampleRewards();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error setting up rewards tables: " . $e->getMessage());
            throw $e;
            return false;
        }
    }
    
    /**
     * Add sample rewards to the database
     */
    private function addSampleRewards() {
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
        
        // Check if rewards table is empty
        $stmt = $this->conn->query("SELECT COUNT(*) FROM rewards");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $stmt = $this->conn->prepare("
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
        }
    }
    
    /**
     * Get distinct reward categories for filtering
     * 
     * @return array Array of category names
     */
    public function getCategories() {
        try {
            $stmt = $this->conn->prepare("SELECT DISTINCT category FROM rewards ORDER BY category");
            $stmt->execute();
            
            $categories = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $row['category'];
            }
            
            return $categories;
        } catch (PDOException $e) {
            error_log("Error fetching reward categories: " . $e->getMessage());
            return [];
        }
    }
} 