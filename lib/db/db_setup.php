<?php
require_once 'config.php';
require_once '../../backend/config/database.php';

// Create database connection
$database = new Database();
$conn = $database->getConnection();

// Check if connection is successful
if (!$conn) {
    die("Database connection failed");
}

echo "<h2>Biz-Fusion Database Setup</h2>";

try {
    // Start transaction
    $conn->beginTransaction();
    
    // Check if users table exists
    $usersExists = false;
    $stmt = $conn->prepare("SHOW TABLES LIKE 'users'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $usersExists = true;
        echo "<p>Users table already exists.</p>";
    }

// Create users table if it doesn't exist
    if (!$usersExists) {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
    user_type ENUM('startup', 'corporate') NOT NULL,
            company_name VARCHAR(100),
            industry VARCHAR(100),
            total_points INT DEFAULT 0,
            level INT DEFAULT 1,
            profile_completion INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            last_login TIMESTAMP NULL
        )";
        $conn->exec($sql);
        echo "<p>Users table created successfully.</p>";
    }
    
    // Check if startup_profiles table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'startup_profiles'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS startup_profiles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            company_size VARCHAR(50),
            founding_year INT,
            funding_stage VARCHAR(100),
            logo_url VARCHAR(255),
            website_url VARCHAR(255),
            description TEXT,
            tags VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Startup profiles table created successfully.</p>";
    } else {
        echo "<p>Startup profiles table already exists.</p>";
    }
    
    // Check if corporate_profiles table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'corporate_profiles'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS corporate_profiles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            company_size VARCHAR(50),
            founding_year INT,
            annual_revenue VARCHAR(100),
            logo_url VARCHAR(255),
            website_url VARCHAR(255),
            description TEXT,
            industry_focus VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Corporate profiles table created successfully.</p>";
    } else {
        echo "<p>Corporate profiles table already exists.</p>";
    }
    
    // Check if points_log table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'points_log'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS points_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            points INT NOT NULL,
            activity VARCHAR(255) NOT NULL,
            date_earned TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Points log table created successfully.</p>";
    } else {
        echo "<p>Points log table already exists.</p>";
    }
    
    // Check if rewards table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'rewards'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS rewards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
            points_cost INT NOT NULL,
            image_url VARCHAR(255),
            user_type ENUM('startup', 'corporate', 'all') NOT NULL DEFAULT 'all',
            quantity INT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "<p>Rewards table created successfully.</p>";
        
        // Add sample rewards
        $rewards = [
            [
                'title' => 'Featured Profile For 1 Week',
                'description' => 'Get your profile featured at the top of search results for 1 week, increasing visibility to potential partners.',
                'points_cost' => 500,
                'image_url' => '../../public/images/rewards/featured_profile.png',
                'user_type' => 'all'
            ],
            [
                'title' => 'Premium Dashboard Access (1 Month)',
                'description' => 'Access advanced analytics, market insights, and competitor analysis for 1 month.',
                'points_cost' => 750,
                'image_url' => '../../public/images/rewards/premium_dashboard.png',
                'user_type' => 'all'
            ],
            [
                'title' => '1-Hour Strategy Consultation',
                'description' => 'Book a 1-hour strategy consultation with one of our business development experts.',
                'points_cost' => 1000,
                'image_url' => '../../public/images/rewards/consultation.png',
                'user_type' => 'all',
                'quantity' => 10
            ],
            [
                'title' => 'Startup Spotlight Article',
                'description' => 'Get your startup featured in our monthly newsletter sent to all corporate partners.',
                'points_cost' => 1500,
                'image_url' => '../../public/images/rewards/spotlight.png',
                'user_type' => 'startup',
                'quantity' => 4
            ],
            [
                'title' => 'Innovation Event Ticket',
                'description' => 'Free ticket to an upcoming innovation event in your region.',
                'points_cost' => 2000,
                'image_url' => '../../public/images/rewards/event_ticket.png',
                'user_type' => 'all',
                'quantity' => 20
            ],
            [
                'title' => 'Corporate Innovation Workshop',
                'description' => 'Host a virtual innovation workshop for your team led by our experts.',
                'points_cost' => 3000,
                'image_url' => '../../public/images/rewards/workshop.png',
                'user_type' => 'corporate',
                'quantity' => 5
            ]
        ];
        
        foreach ($rewards as $reward) {
            $stmt = $conn->prepare("INSERT INTO rewards (title, description, points_cost, image_url, user_type, quantity) 
                             VALUES (:title, :description, :points_cost, :image_url, :user_type, :quantity)");
            $stmt->bindParam(':title', $reward['title']);
            $stmt->bindParam(':description', $reward['description']);
            $stmt->bindParam(':points_cost', $reward['points_cost']);
            $stmt->bindParam(':image_url', $reward['image_url']);
            $stmt->bindParam(':user_type', $reward['user_type']);
            $quantity = isset($reward['quantity']) ? $reward['quantity'] : null;
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
        }
        
        echo "<p>Sample rewards added successfully.</p>";
    } else {
        echo "<p>Rewards table already exists.</p>";
    }
    
    // Check if reward_redemptions table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'reward_redemptions'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS reward_redemptions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            reward_id INT NOT NULL,
            points_spent INT NOT NULL,
            redemption_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
            notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reward_id) REFERENCES rewards(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Reward redemptions table created successfully.</p>";
    } else {
        echo "<p>Reward redemptions table already exists.</p>";
    }
    
    // Check if innovation_needs table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'innovation_needs'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS innovation_needs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            corporate_id INT NOT NULL,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            categories VARCHAR(255),
            status ENUM('active', 'closed', 'pending') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (corporate_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Innovation needs table created successfully.</p>";
    } else {
        echo "<p>Innovation needs table already exists.</p>";
    }
    
    // Check if startup_solutions table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'startup_solutions'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS startup_solutions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            startup_id INT NOT NULL,
            need_id INT NOT NULL,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            status ENUM('submitted', 'reviewed', 'accepted', 'rejected') DEFAULT 'submitted',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (startup_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (need_id) REFERENCES innovation_needs(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Startup solutions table created successfully.</p>";
    } else {
        echo "<p>Startup solutions table already exists.</p>";
    }
    
    // Check if partnerships table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'partnerships'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS partnerships (
            id INT AUTO_INCREMENT PRIMARY KEY,
            startup_id INT NOT NULL,
            corporate_id INT NOT NULL,
            status ENUM('pending', 'active', 'completed', 'canceled') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (startup_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (corporate_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
        echo "<p>Partnerships table created successfully.</p>";
    } else {
        echo "<p>Partnerships table already exists.</p>";
    }
    
    // Check if services table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'services'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS services (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            description TEXT NOT NULL,
            icon VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "<p>Services table created successfully.</p>";
        
        // Add sample services
        $services = [
            [
                'title' => 'Smart Matching',
                'description' => 'Our AI-powered algorithm connects startups with corporate partners based on mutual interests, technologies, and business objectives.',
                'icon' => 'fas fa-network-wired'
            ],
            [
                'title' => 'Verified Partnerships',
                'description' => 'All businesses on our platform undergo thorough verification to ensure safe, transparent, and valuable partnerships.',
                'icon' => 'fas fa-shield-alt'
            ],
            [
                'title' => 'Funding Access',
                'description' => 'Startups gain access to potential investment opportunities, while corporates find innovative solutions to business challenges.',
                'icon' => 'fas fa-hand-holding-usd'
            ],
            [
                'title' => 'Events & Networking',
                'description' => 'Access to exclusive virtual and in-person events designed to facilitate meaningful connections between startups and corporates.',
                'icon' => 'fas fa-calendar-alt'
            ],
            [
                'title' => 'Innovation Challenges',
                'description' => 'Corporates can post innovation challenges, and startups can submit tailored solutions, fostering targeted collaborations.',
                'icon' => 'fas fa-lightbulb'
            ],
            [
                'title' => 'Resources & Guides',
                'description' => 'Access to comprehensive guides, best practices, and resources for successful startup-corporate partnerships.',
                'icon' => 'fas fa-book'
            ]
        ];
        
        foreach ($services as $service) {
            $stmt = $conn->prepare("INSERT INTO services (title, description, icon) VALUES (:title, :description, :icon)");
            $stmt->bindParam(':title', $service['title']);
            $stmt->bindParam(':description', $service['description']);
            $stmt->bindParam(':icon', $service['icon']);
            $stmt->execute();
        }
        
        echo "<p>Sample services added successfully.</p>";
    } else {
        echo "<p>Services table already exists.</p>";
    }
    
    // Check if success_stories table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'success_stories'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS success_stories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            image_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "<p>Success stories table created successfully.</p>";
        
        // Add sample success stories
        $stories = [
            [
                'title' => 'TechStart & GlobalCorp',
                'description' => 'TechStart connected with GlobalCorp through Biz-Fusion and secured a $1.5M investment to scale their AI solution. The partnership led to a 300% increase in revenue for TechStart within just one year.',
                'image_url' => '../../public/images/success_stories/story1.jpg'
            ],
            [
                'title' => 'EcoSolutions & EnergyCorp',
                'description' => 'EcoSolutions found the perfect corporate partner in EnergyCorp after struggling to scale their renewable energy tech. Within 6 months of connecting through Biz-Fusion, they launched in 3 new markets and doubled their team size.',
                'image_url' => '../../public/images/success_stories/story2.jpg'
            ]
        ];
        
        foreach ($stories as $story) {
            $stmt = $conn->prepare("INSERT INTO success_stories (title, description, image_url) VALUES (:title, :description, :image_url)");
            $stmt->bindParam(':title', $story['title']);
            $stmt->bindParam(':description', $story['description']);
            $stmt->bindParam(':image_url', $story['image_url']);
            $stmt->execute();
        }
        
        echo "<p>Sample success stories added successfully.</p>";
    } else {
        echo "<p>Success stories table already exists.</p>";
    }
    
    // Check if contact_messages table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'contact_messages'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(200) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "<p>Contact messages table created successfully.</p>";
    } else {
        echo "<p>Contact messages table already exists.</p>";
    }
    
    // Commit transaction
    $conn->commit();
    
    echo "<p>Database setup completed successfully!</p>";
    echo "<p><a href='../../index.php' class='text-primary'>Go to Homepage</a></p>";
    
} catch (PDOException $e) {
    // Rollback transaction on error
    $conn->rollBack();
    echo "<p>Error setting up database: " . $e->getMessage() . "</p>";
}
?> 