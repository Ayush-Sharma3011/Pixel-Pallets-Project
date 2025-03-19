<?php
require_once 'config.php';

class PointsSystem {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
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
        // First, update the user's total points
        $updateQuery = "UPDATE users SET total_points = total_points + ? WHERE id = ?";
        $stmt = $this->conn->prepare($updateQuery);
        $stmt->bind_param("ii", $points, $user_id);
        $result = $stmt->execute();
        
        if (!$result) {
            return false;
        }
        
        // Then, log the points transaction
        $logQuery = "INSERT INTO points_log (user_id, points, activity, date_earned) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($logQuery);
        $stmt->bind_param("iis", $user_id, $points, $activity);
        return $stmt->execute();
    }
    
    /**
     * Award points for user login (once per day)
     * 
     * @param int $user_id The user ID
     * @return bool True if points were awarded, false otherwise
     */
    public function awardLoginPoints($user_id) {
        // Check if user already received login points today
        $checkQuery = "SELECT COUNT(*) as count FROM points_log 
                      WHERE user_id = ? AND activity = 'Daily Login' 
                      AND DATE(date_earned) = CURDATE()";
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // If user hasn't received login points today, award them
        if ($row['count'] == 0) {
            return $this->awardPoints($user_id, POINTS_LOGIN, 'Daily Login');
        }
        
        return false;
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
     * Get user's total points
     * 
     * @param int $user_id The user ID
     * @return int The total points
     */
    public function getUserPoints($user_id) {
        $query = "SELECT total_points FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['total_points'];
        }
        
        return 0;
    }
    
    /**
     * Get user's points history
     * 
     * @param int $user_id The user ID
     * @param int $limit Optional limit on number of records
     * @return array The points history
     */
    public function getPointsHistory($user_id, $limit = 10) {
        $query = "SELECT points, activity, date_earned FROM points_log 
                 WHERE user_id = ? ORDER BY date_earned DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        
        return $history;
    }
    
    /**
     * Get leaderboard of users with highest points
     * 
     * @param int $limit Number of users to return
     * @return array The leaderboard data
     */
    public function getLeaderboard($limit = 10) {
        $query = "SELECT id, username, total_points, user_type FROM users 
                 ORDER BY total_points DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $leaderboard = [];
        while ($row = $result->fetch_assoc()) {
            $leaderboard[] = $row;
        }
        
        return $leaderboard;
    }
}
?> 