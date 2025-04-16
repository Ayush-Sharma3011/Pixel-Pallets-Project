<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/points_config.php';

class Points {
    private $conn;
    private $points_table = "points_log";
    private $users_table = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Award points to a user
     * 
     * @param int $user_id The user ID
     * @param int $points The number of points to award
     * @param string $activity The activity description
     * @return bool True if successful, false otherwise
     */
    public function awardPoints($user_id, $points, $activity) {
        try {
            // Start transaction
            $this->conn->beginTransaction();
            
            // First, update the user's total points
            $updateQuery = "UPDATE " . $this->users_table . " 
                          SET total_points = total_points + :points 
                          WHERE id = :user_id";
            
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(':points', $points, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->conn->rollBack();
                return false;
            }
            
            // Then, log the points transaction
            $logQuery = "INSERT INTO " . $this->points_table . " 
                        (user_id, points, activity) 
                        VALUES (:user_id, :points, :activity)";
            
            $stmt = $this->conn->prepare($logQuery);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':points', $points, PDO::PARAM_INT);
            $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
            
            $result = $stmt->execute();
            
            if ($result) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Points award error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Award points for user login (once per day)
     * 
     * @param int $user_id The user ID
     * @return bool True if points were awarded, false otherwise
     */
    public function awardLoginPoints($user_id) {
        try {
            // Check if user already received login points today
            $checkQuery = "SELECT COUNT(*) FROM " . $this->points_table . " 
                          WHERE user_id = :user_id AND activity = 'Daily Login' 
                          AND DATE(date_earned) = CURDATE()";
            
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // If user hasn't received login points today, award them
            if ($stmt->fetchColumn() == 0) {
                return $this->awardPoints($user_id, POINTS_LOGIN, 'Daily Login');
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Login points error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Award points for registration
     * 
     * @param int $user_id The user ID
     * @param string $user_type 'startup' or 'corporate'
     * @return bool True if successful, false otherwise
     */
    public function awardRegistrationPoints($user_id, $user_type) {
        $points = ($user_type == 'startup') ? POINTS_REGISTER_STARTUP : POINTS_REGISTER_CORPORATE;
        $activity = 'Registration as ' . ucfirst($user_type);
        
        return $this->awardPoints($user_id, $points, $activity);
    }
    
    /**
     * Award points for completing profile
     * 
     * @param int $user_id The user ID
     * @return bool True if successful, false otherwise
     */
    public function awardProfileCompletionPoints($user_id) {
        return $this->awardPoints($user_id, POINTS_COMPLETE_PROFILE, 'Profile Completion');
    }
    
    /**
     * Award points for connecting with a match
     * 
     * @param int $user_id The user ID
     * @param int $match_id The match ID
     * @return bool True if successful, false otherwise
     */
    public function awardConnectionPoints($user_id, $match_id) {
        $activity = "Connected with Match #$match_id";
        return $this->awardPoints($user_id, POINTS_CONNECT_MATCH, $activity);
    }
    
    /**
     * Award points for posting an innovation need (corporate)
     * 
     * @param int $user_id The user ID
     * @param int $need_id The innovation need ID
     * @return bool True if successful, false otherwise
     */
    public function awardInnovationNeedPoints($user_id, $need_id) {
        $activity = "Posted Innovation Need #$need_id";
        return $this->awardPoints($user_id, POINTS_POST_INNOVATION_NEED, $activity);
    }
    
    /**
     * Award points for submitting a solution (startup)
     * 
     * @param int $user_id The user ID
     * @param int $solution_id The solution ID
     * @return bool True if successful, false otherwise
     */
    public function awardSolutionPoints($user_id, $solution_id) {
        $activity = "Submitted Solution #$solution_id";
        return $this->awardPoints($user_id, POINTS_SUBMIT_SOLUTION, $activity);
    }
    
    /**
     * Award points for successful partnership
     * 
     * @param int $user_id The user ID
     * @param int $partnership_id The partnership ID
     * @return bool True if successful, false otherwise
     */
    public function awardPartnershipPoints($user_id, $partnership_id) {
        $activity = "Formed Partnership #$partnership_id";
        return $this->awardPoints($user_id, POINTS_SUCCESSFUL_PARTNERSHIP, $activity);
    }
    
    /**
     * Award points for sharing a resource
     * 
     * @param int $user_id The user ID
     * @param string $resource_title The resource title
     * @return bool True if successful, false otherwise
     */
    public function awardShareResourcePoints($user_id, $resource_title) {
        $activity = "Shared Resource: " . substr($resource_title, 0, 50);
        return $this->awardPoints($user_id, POINTS_SHARE_RESOURCE, $activity);
    }
    
    /**
     * Award points for attending an event
     * 
     * @param int $user_id The user ID
     * @param string $event_title The event title
     * @return bool True if successful, false otherwise
     */
    public function awardEventAttendancePoints($user_id, $event_title) {
        $activity = "Attended Event: " . substr($event_title, 0, 50);
        return $this->awardPoints($user_id, POINTS_ATTEND_EVENT, $activity);
    }
    
    /**
     * Get user's total points
     * 
     * @param int $user_id The user ID
     * @return int The total points
     */
    public function getUserPoints($user_id) {
        try {
            $query = "SELECT total_points FROM " . $this->users_table . " WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return (int)$row['total_points'];
            }
            
            return 0;
        } catch (PDOException $e) {
            error_log("Get user points error: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get user's points history
     * 
     * @param int $user_id The user ID
     * @param int $limit Optional limit on number of records
     * @param int $offset Optional offset for pagination
     * @return array The points history
     */
    public function getPointsHistory($user_id, $limit = 10, $offset = 0) {
        try {
            $query = "SELECT id, points, activity, date_earned FROM " . $this->points_table . " 
                     WHERE user_id = :user_id 
                     ORDER BY date_earned DESC 
                     LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get points history error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get user's current level based on points
     * 
     * @param int $user_id The user ID
     * @return array The level data
     */
    public function getUserLevel($user_id) {
        $points = $this->getUserPoints($user_id);
        $level = 1;
        
        global $POINTS_LEVELS, $LEVEL_BENEFITS;
        
        foreach ($POINTS_LEVELS as $lvl => $required) {
            if ($points >= $required) {
                $level = $lvl;
            } else {
                break;
            }
        }
        
        $next_level = $level < 5 ? $level + 1 : 5;
        $points_needed = $level < 5 ? $POINTS_LEVELS[$next_level] - $points : 0;
        
        return [
            'current_level' => $level,
            'level_name' => $this->getLevelName($level),
            'current_points' => $points,
            'next_level' => $next_level,
            'next_level_name' => $this->getLevelName($next_level),
            'points_needed' => $points_needed,
            'benefits' => $LEVEL_BENEFITS[$level]
        ];
    }
    
    /**
     * Get level name based on level number
     * 
     * @param int $level The level number
     * @return string The level name
     */
    private function getLevelName($level) {
        $names = [
            1 => 'Bronze',
            2 => 'Silver',
            3 => 'Gold',
            4 => 'Platinum',
            5 => 'Diamond'
        ];
        
        return isset($names[$level]) ? $names[$level] : 'Unknown';
    }
    
    /**
     * Get leaderboard of users with highest points
     * 
     * @param int $limit Number of users to return
     * @param string $user_type Optional filter by user type
     * @return array The leaderboard data
     */
    public function getLeaderboard($limit = 10, $user_type = null) {
        try {
            $query = "SELECT id, username, company_name, user_type, total_points 
                     FROM " . $this->users_table;
            
            if ($user_type) {
                $query .= " WHERE user_type = :user_type";
            }
            
            $query .= " ORDER BY total_points DESC LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            
            if ($user_type) {
                $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            }
            
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get leaderboard error: " . $e->getMessage());
            return [];
        }
    }
}
?> 