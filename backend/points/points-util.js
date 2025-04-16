/**
 * PixelPallets Points Utility
 * JavaScript utility for interacting with the points system
 */

const PointsUtil = {
    /**
     * Award points for a specific action
     * 
     * @param {string} action - The points action (award_login, award_profile_completion, etc.)
     * @param {Object} params - Additional parameters needed for the action
     * @returns {Promise} - Promise resolving to the response data
     */
    awardPoints: function(action, params = {}) {
        // Create form data
        const formData = new FormData();
        formData.append('action', action);
        
        // Add any additional parameters
        for (const key in params) {
            formData.append(key, params[key]);
        }
        
        // Send request to the points handler
        return fetch('backend/points/points-handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
    },
    
    /**
     * Get user's total points
     * 
     * @returns {Promise} - Promise resolving to the total points
     */
    getUserPoints: function() {
        return fetch('backend/points/points-handler.php?action=get_points')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    return data.data.total_points;
                }
                throw new Error(data.message || 'Failed to get points');
            });
    },
    
    /**
     * Get user's points history
     * 
     * @param {number} limit - Number of history items to return
     * @param {number} offset - Offset for pagination
     * @returns {Promise} - Promise resolving to the points history array
     */
    getPointsHistory: function(limit = 10, offset = 0) {
        return fetch(`backend/points/points-handler.php?action=get_history&limit=${limit}&offset=${offset}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    return data.data.history;
                }
                throw new Error(data.message || 'Failed to get points history');
            });
    },
    
    /**
     * Get user's current level information
     * 
     * @returns {Promise} - Promise resolving to the level information
     */
    getUserLevel: function() {
        return fetch('backend/points/points-handler.php?action=get_level')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    return data.data;
                }
                throw new Error(data.message || 'Failed to get level information');
            });
    },
    
    /**
     * Get points leaderboard
     * 
     * @param {number} limit - Number of users to include in leaderboard
     * @param {string} userType - Filter by user type ('startup' or 'corporate')
     * @returns {Promise} - Promise resolving to the leaderboard data
     */
    getLeaderboard: function(limit = 10, userType = null) {
        let url = `backend/points/points-handler.php?action=get_leaderboard&limit=${limit}`;
        if (userType) {
            url += `&user_type=${userType}`;
        }
        
        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    return data.data.leaderboard;
                }
                throw new Error(data.message || 'Failed to get leaderboard');
            });
    },
    
    /**
     * Award points for login (to be called after successful login)
     * 
     * @returns {Promise} - Promise resolving to the response data
     */
    awardLoginPoints: function() {
        return this.awardPoints('award_login');
    },
    
    /**
     * Award points for profile completion
     * 
     * @returns {Promise} - Promise resolving to the response data
     */
    awardProfileCompletionPoints: function() {
        return this.awardPoints('award_profile_completion');
    },
    
    /**
     * Award points for connecting with a match
     * 
     * @param {number} matchId - ID of the match
     * @returns {Promise} - Promise resolving to the response data
     */
    awardConnectionPoints: function(matchId) {
        return this.awardPoints('award_connection', { match_id: matchId });
    },
    
    /**
     * Award points for posting an innovation need (corporate users)
     * 
     * @param {number} needId - ID of the innovation need
     * @returns {Promise} - Promise resolving to the response data
     */
    awardInnovationNeedPoints: function(needId) {
        return this.awardPoints('award_innovation_need', { need_id: needId });
    },
    
    /**
     * Award points for submitting a solution (startup users)
     * 
     * @param {number} solutionId - ID of the solution
     * @returns {Promise} - Promise resolving to the response data
     */
    awardSolutionPoints: function(solutionId) {
        return this.awardPoints('award_solution', { solution_id: solutionId });
    }
};

// Example usage:
/*
// Award login points
PointsUtil.awardLoginPoints()
    .then(response => {
        if (response.success) {
            console.log(`You were awarded ${response.data.points_awarded} points!`);
            console.log(`Total points: ${response.data.total_points}`);
        } else {
            console.log(response.message);
        }
    })
    .catch(error => console.error('Error:', error));

// Get user's level information
PointsUtil.getUserLevel()
    .then(levelInfo => {
        console.log(`You are level ${levelInfo.level}: ${levelInfo.level_name}`);
        console.log(`Points: ${levelInfo.current_points}/${levelInfo.next_level_points}`);
    })
    .catch(error => console.error('Error:', error));
*/ 