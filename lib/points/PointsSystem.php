<?php
/**
 * Points System Class
 * 
 * Handles all points-related functionality including:
 * - Awarding points for various activities
 * - Tracking points history
 * - Checking point thresholds for level upgrades
 */

require_once __DIR__ . '/../../backend/config/points_config.php';

class PointsSystem {
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
     * Award points for user registration
     * 
     * @param int $user_id User ID
     * @param string $user_type User type (startup or corporate)
     * @return bool Success status
     */
    public function awardRegistrationPoints($user_id, $user_type) {
        $points = ($user_type == 'startup') ? POINTS_REGISTER_STARTUP : POINTS_REGISTER_CORPORATE;
        $activity = "Registration as " . ucfirst($user_type);
        
        return $this->addPoints($user_id, $points, $activity);
    }
    
    /**
     * Award points for daily login
     * 
     * @param int $user_id User ID
     * @return bool Success status
     */
    public function awardLoginPoints($user_id) {
        // Check if user already got login points today
        $stmt = $this->conn->prepare("SELECT id FROM points_log 
                               WHERE user_id = :user_id 
                               AND activity = 'Daily Login' 
                               AND DATE(date_earned) = CURDATE()");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // User already got login points today
            return false;
        }
        
        // Award points for login
        return $this->addPoints($user_id, POINTS_LOGIN, 'Daily Login');
    }
    
    /**
     * Award points for completing profile
     * 
     * @param int $user_id User ID
     * @return bool Success status
     */
    public function awardProfileCompletionPoints($user_id) {
        // Check if user already got profile completion points
        $stmt = $this->conn->prepare("SELECT id FROM points_log 
                               WHERE user_id = :user_id 
                               AND activity = 'Profile Completion'");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // User already got profile completion points
            return false;
        }
        
        // Award points for profile completion
        return $this->addPoints($user_id, POINTS_COMPLETE_PROFILE, 'Profile Completion');
    }
    
    /**
     * Award points for uploading a logo
     * 
     * @param int $user_id User ID
     * @return bool Success status
     */
    public function awardLogoUploadPoints($user_id) {
        // Check if user already got logo upload points
        $stmt = $this->conn->prepare("SELECT id FROM points_log 
                               WHERE user_id = :user_id 
                               AND activity = 'Logo Upload'");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // User already got logo upload points
            return false;
        }
        
        // Award points for logo upload
        return $this->addPoints($user_id, POINTS_UPLOAD_LOGO, 'Logo Upload');
    }
    
    /**
     * Award points for posting an innovation need (corporate only)
     * 
     * @param int $user_id User ID
     * @param int $need_id Innovation need ID
     * @return bool Success status
     */
    public function awardInnovationNeedPoints($user_id, $need_id) {
        $activity = "Posted Innovation Need #" . $need_id;
        
        return $this->addPoints($user_id, POINTS_POST_INNOVATION_NEED, $activity);
    }
    
    /**
     * Award points for submitting a solution (startup only)
     * 
     * @param int $user_id User ID
     * @param int $solution_id Solution ID
     * @return bool Success status
     */
    public function awardSolutionSubmissionPoints($user_id, $solution_id) {
        $activity = "Submitted Solution #" . $solution_id;
        
        return $this->addPoints($user_id, POINTS_SUBMIT_SOLUTION, $activity);
    }
    
    /**
     * Award points for connecting with a match
     * 
     * @param int $user_id User ID
     * @param int $match_id Match ID
     * @return bool Success status
     */
    public function awardConnectionPoints($user_id, $match_id) {
        $activity = "Connected with Match #" . $match_id;
        
        return $this->addPoints($user_id, POINTS_CONNECT_MATCH, $activity);
    }
    
    /**
     * Award points for forming a successful partnership
     * 
     * @param int $user_id User ID
     * @param int $partnership_id Partnership ID
     * @return bool Success status
     */
    public function awardPartnershipPoints($user_id, $partnership_id) {
        $activity = "Formed Partnership #" . $partnership_id;
        
        return $this->addPoints($user_id, POINTS_SUCCESSFUL_PARTNERSHIP, $activity);
    }
    
    /**
     * Award achievement bonus points
     * 
     * @param int $user_id User ID
     * @param string $achievement Achievement name
     * @param int $points Points to award
     * @return bool Success status
     */
    public function awardAchievementPoints($user_id, $achievement, $points) {
        $activity = "Achievement: " . $achievement;
        
        return $this->addPoints($user_id, $points, $activity);
    }
    
    /**
     * Add points to a user's account and log the activity
     * 
     * @param int $user_id User ID
     * @param int $points Points to add
     * @param string $activity Activity description
     * @return bool Success status
     */
    private function addPoints($user_id, $points, $activity) {
        try {
            // Begin transaction
            $this->conn->beginTransaction();
            
            // Add points to user's total
            $stmt = $this->conn->prepare("UPDATE users SET total_points = total_points + :points WHERE id = :user_id");
            $stmt->bindParam(':points', $points);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            
            // Log the points activity
            $stmt = $this->conn->prepare("INSERT INTO points_log (user_id, points, activity, date_earned) 
                                   VALUES (:user_id, :points, :activity, NOW())");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':points', $points);
            $stmt->bindParam(':activity', $activity);
            $stmt->execute();
            
            // Check for level up
            $this->checkForLevelUp($user_id);
            
            // Commit transaction
            $this->conn->commit();
            
            return true;
            
        } catch (PDOException $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            error_log("Error awarding points: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if user has reached a new level based on total points
     * 
     * @param int $user_id User ID
     * @return bool Whether user leveled up
     */
    private function checkForLevelUp($user_id) {
        global $POINTS_LEVELS;
        
        // Get user's current total points
        $stmt = $this->conn->prepare("SELECT total_points FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_points = $user['total_points'];
        
        // Determine user's new level based on total points
        $new_level = 1; // Default level
        foreach ($POINTS_LEVELS as $level => $required_points) {
            if ($total_points >= $required_points) {
                $new_level = $level;
            } else {
                break;
            }
        }
        
        // Get user's current level
        $stmt = $this->conn->prepare("SELECT level FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_level = $user['level'] ?? 1;
        
        // If user has leveled up, update their level
        if ($new_level > $current_level) {
            $stmt = $this->conn->prepare("UPDATE users SET level = :new_level WHERE id = :user_id");
            $stmt->bindParam(':new_level', $new_level);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            
            // Log the level up event
            $activity = "Leveled up to Level " . $new_level;
            $levelup_points = 0; // No points awarded for leveling up
            $stmt = $this->conn->prepare("INSERT INTO points_log (user_id, points, activity, date_earned) 
                                   VALUES (:user_id, :points, :activity, NOW())");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':points', $levelup_points);
            $stmt->bindParam(':activity', $activity);
            $stmt->execute();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Get user's points history
     * 
     * @param int $user_id User ID
     * @param int $limit Optional limit of records to return
     * @return array Points history records
     */
    public function getPointsHistory($user_id, $limit = 10) {
        $stmt = $this->conn->prepare("SELECT * FROM points_log 
                               WHERE user_id = :user_id 
                               ORDER BY date_earned DESC 
                               LIMIT :limit");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's current level
     * 
     * @param int $user_id User ID
     * @return int User's current level
     */
    public function getUserLevel($user_id) {
        $stmt = $this->conn->prepare("SELECT level FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user['level'] ?? 1;
    }
    
    /**
     * Get user's current total points
     * 
     * @param int $user_id User ID
     * @return int User's total points
     */
    public function getUserPoints($user_id) {
        $stmt = $this->conn->prepare("SELECT total_points FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user['total_points'] ?? 0;
    }
    
    /**
     * Get points needed for next level
     * 
     * @param int $user_id User ID
     * @return array Next level information
     */
    public function getNextLevelInfo($user_id) {
        global $POINTS_LEVELS;
        
        $current_points = $this->getUserPoints($user_id);
        $current_level = $this->getUserLevel($user_id);
        $next_level = $current_level + 1;
        
        if (!isset($POINTS_LEVELS[$next_level])) {
            // User is at max level
            return [
                'current_level' => $current_level,
                'next_level' => null,
                'points_needed' => 0,
                'progress_percent' => 100
            ];
        }
        
        $next_level_points = $POINTS_LEVELS[$next_level];
        $points_needed = $next_level_points - $current_points;
        
        // Calculate progress percentage
        $current_level_points = $POINTS_LEVELS[$current_level];
        $level_range = $next_level_points - $current_level_points;
        $progress = $current_points - $current_level_points;
        $progress_percent = ($progress / $level_range) * 100;
        
        return [
            'current_level' => $current_level,
            'next_level' => $next_level,
            'current_points' => $current_points,
            'next_level_points' => $next_level_points,
            'points_needed' => $points_needed,
            'progress_percent' => $progress_percent
        ];
    }
}
?> 