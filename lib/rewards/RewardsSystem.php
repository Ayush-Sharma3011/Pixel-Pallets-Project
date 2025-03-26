<?php
/**
 * RewardsSystem Class
 * 
 * This class manages the rewards system functionality, including:
 * - Retrieving available rewards
 * - Checking if a user qualifies for rewards
 * - Redeeming rewards
 * - Tracking redeemed rewards
 */

class RewardsSystem {
    private $db;
    
    /**
     * Constructor
     * 
     * @param mysqli $db Database connection
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Get all available rewards
     * 
     * @return array Array of rewards
     */
    public function getAvailableRewards() {
        $stmt = $this->db->prepare('SELECT * FROM rewards WHERE is_active = 1 ORDER BY points_required ASC');
        $stmt->execute();
        $result = $stmt->get_result();
        
        $rewards = [];
        while ($row = $result->fetch_assoc()) {
            $rewards[] = $row;
        }
        
        return $rewards;
    }
    
    /**
     * Get rewards available to a specific user based on their point balance
     * 
     * @param int $user_id The user ID
     * @return array Array of rewards available to the user
     */
    public function getAvailableRewardsForUser($user_id) {
        // Get user's current points
        $points_stmt = $this->db->prepare('SELECT total_points FROM users WHERE id = ?');
        $points_stmt->bind_param('i', $user_id);
        $points_stmt->execute();
        $points_result = $points_stmt->get_result();
        $user_data = $points_result->fetch_assoc();
        $total_points = $user_data['total_points'];
        
        // Get rewards that the user can afford
        $rewards_stmt = $this->db->prepare('
            SELECT * FROM rewards 
            WHERE is_active = 1 AND points_required <= ? 
            ORDER BY points_required ASC
        ');
        $rewards_stmt->bind_param('i', $total_points);
        $rewards_stmt->execute();
        $rewards_result = $rewards_stmt->get_result();
        
        $rewards = [];
        while ($row = $rewards_result->fetch_assoc()) {
            $rewards[] = $row;
        }
        
        return $rewards;
    }
    
    /**
     * Get rewards already redeemed by a user
     * 
     * @param int $user_id The user ID
     * @return array Array of redeemed rewards
     */
    public function getUserRedeemedRewards($user_id) {
        $stmt = $this->db->prepare('
            SELECT ur.id, ur.redeemed_date, ur.status, r.name, r.description, r.points_required 
            FROM user_rewards ur
            JOIN rewards r ON ur.reward_id = r.id
            WHERE ur.user_id = ?
            ORDER BY ur.redeemed_date DESC
        ');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $redeemed_rewards = [];
        while ($row = $result->fetch_assoc()) {
            $redeemed_rewards[] = $row;
        }
        
        return $redeemed_rewards;
    }
    
    /**
     * Check if a user can redeem a specific reward
     * 
     * @param int $user_id The user ID
     * @param int $reward_id The reward ID
     * @return bool True if the user can redeem the reward, false otherwise
     */
    public function canRedeemReward($user_id, $reward_id) {
        // Get user's current points
        $points_stmt = $this->db->prepare('SELECT total_points FROM users WHERE id = ?');
        $points_stmt->bind_param('i', $user_id);
        $points_stmt->execute();
        $points_result = $points_stmt->get_result();
        $user_data = $points_result->fetch_assoc();
        $total_points = $user_data['total_points'];
        
        // Get reward details
        $reward_stmt = $this->db->prepare('SELECT points_required, is_active FROM rewards WHERE id = ?');
        $reward_stmt->bind_param('i', $reward_id);
        $reward_stmt->execute();
        $reward_result = $reward_stmt->get_result();
        $reward_data = $reward_result->fetch_assoc();
        
        // Check if reward exists and is active
        if (!$reward_data || !$reward_data['is_active']) {
            return false;
        }
        
        // Check if user has enough points
        return $total_points >= $reward_data['points_required'];
    }
    
    /**
     * Redeem a reward for a user
     * 
     * @param int $user_id The user ID
     * @param int $reward_id The reward ID
     * @return array Result with success status and message
     */
    public function redeemReward($user_id, $reward_id) {
        // First check if the user can redeem this reward
        if (!$this->canRedeemReward($user_id, $reward_id)) {
            return [
                'success' => false,
                'message' => 'You do not have enough points to redeem this reward.'
            ];
        }
        
        // Get reward details
        $reward_stmt = $this->db->prepare('SELECT name, points_required FROM rewards WHERE id = ?');
        $reward_stmt->bind_param('i', $reward_id);
        $reward_stmt->execute();
        $reward_result = $reward_stmt->get_result();
        $reward_data = $reward_result->fetch_assoc();
        
        // Start transaction
        $this->db->begin_transaction();
        
        try {
            // Deduct points from user
            $update_points_stmt = $this->db->prepare('
                UPDATE users 
                SET total_points = total_points - ? 
                WHERE id = ?
            ');
            $update_points_stmt->bind_param('ii', $reward_data['points_required'], $user_id);
            $update_points_stmt->execute();
            
            // Add record to user_rewards table
            $status = 'pending';
            $insert_stmt = $this->db->prepare('
                INSERT INTO user_rewards (user_id, reward_id, redeemed_date, status) 
                VALUES (?, ?, NOW(), ?)
            ');
            $insert_stmt->bind_param('iis', $user_id, $reward_id, $status);
            $insert_stmt->execute();
            
            // Add record to points_log for the redemption
            $activity = 'Reward redemption: ' . $reward_data['name'];
            $points = -$reward_data['points_required']; // Negative points for redemption
            $points_log_stmt = $this->db->prepare('
                INSERT INTO points_log (user_id, points, activity, date_earned) 
                VALUES (?, ?, ?, NOW())
            ');
            $points_log_stmt->bind_param('iis', $user_id, $points, $activity);
            $points_log_stmt->execute();
            
            // Commit transaction
            $this->db->commit();
            
            // Update session points total
            if (isset($_SESSION['total_points'])) {
                $_SESSION['total_points'] -= $reward_data['points_required'];
            }
            
            return [
                'success' => true,
                'message' => 'You have successfully redeemed the ' . $reward_data['name'] . ' reward.',
                'reward' => $reward_data['name'],
                'points_spent' => $reward_data['points_required']
            ];
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollback();
            
            return [
                'success' => false,
                'message' => 'An error occurred while redeeming the reward. Please try again.'
            ];
        }
    }
    
    /**
     * Get all rewards for admin management
     * 
     * @return array Array of all rewards
     */
    public function getAllRewards() {
        $stmt = $this->db->prepare('SELECT * FROM rewards ORDER BY points_required ASC');
        $stmt->execute();
        $result = $stmt->get_result();
        
        $rewards = [];
        while ($row = $result->fetch_assoc()) {
            $rewards[] = $row;
        }
        
        return $rewards;
    }
    
    /**
     * Add a new reward
     * 
     * @param string $name Reward name
     * @param string $description Reward description
     * @param int $points_required Points required to redeem
     * @param bool $is_active Whether the reward is active
     * @return bool True if successful, false otherwise
     */
    public function addReward($name, $description, $points_required, $is_active = true) {
        $stmt = $this->db->prepare('
            INSERT INTO rewards (name, description, points_required, is_active) 
            VALUES (?, ?, ?, ?)
        ');
        $stmt->bind_param('ssii', $name, $description, $points_required, $is_active);
        
        return $stmt->execute();
    }
    
    /**
     * Update an existing reward
     * 
     * @param int $reward_id Reward ID
     * @param string $name Reward name
     * @param string $description Reward description
     * @param int $points_required Points required to redeem
     * @param bool $is_active Whether the reward is active
     * @return bool True if successful, false otherwise
     */
    public function updateReward($reward_id, $name, $description, $points_required, $is_active) {
        $stmt = $this->db->prepare('
            UPDATE rewards 
            SET name = ?, description = ?, points_required = ?, is_active = ? 
            WHERE id = ?
        ');
        $stmt->bind_param('ssiii', $name, $description, $points_required, $is_active, $reward_id);
        
        return $stmt->execute();
    }
    
    /**
     * Delete a reward
     * 
     * @param int $reward_id Reward ID
     * @return bool True if successful, false otherwise
     */
    public function deleteReward($reward_id) {
        // First check if any users have redeemed this reward
        $check_stmt = $this->db->prepare('SELECT COUNT(*) as count FROM user_rewards WHERE reward_id = ?');
        $check_stmt->bind_param('i', $reward_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $count_data = $check_result->fetch_assoc();
        
        // If reward has been redeemed, just deactivate it instead of deleting
        if ($count_data['count'] > 0) {
            $stmt = $this->db->prepare('UPDATE rewards SET is_active = 0 WHERE id = ?');
            $stmt->bind_param('i', $reward_id);
            return $stmt->execute();
        }
        
        // Otherwise, delete it completely
        $stmt = $this->db->prepare('DELETE FROM rewards WHERE id = ?');
        $stmt->bind_param('i', $reward_id);
        return $stmt->execute();
    }
} 