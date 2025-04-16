<?php
require_once '../config/config.php';
require_once '../models/Points.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];
$points = new Points();

// Process action based on request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the action from POST data
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'award_login':
            // Award points for daily login
            $result = $points->awardLoginPoints($user_id);
            if ($result) {
                $_SESSION['points_message'] = 'You earned points for logging in today!';
                $_SESSION['points_amount'] = POINTS_LOGIN;
                $response['success'] = true;
                $response['message'] = 'Login points awarded';
                $response['data'] = [
                    'points_awarded' => POINTS_LOGIN,
                    'total_points' => $points->getUserPoints($user_id)
                ];
            } else {
                $response['message'] = 'Already received login points today';
            }
            break;
            
        case 'award_profile_completion':
            // Award points for completing profile
            $result = $points->awardProfileCompletionPoints($user_id);
            if ($result) {
                $_SESSION['points_message'] = 'You earned points for completing your profile!';
                $_SESSION['points_amount'] = POINTS_COMPLETE_PROFILE;
                $response['success'] = true;
                $response['message'] = 'Profile completion points awarded';
                $response['data'] = [
                    'points_awarded' => POINTS_COMPLETE_PROFILE,
                    'total_points' => $points->getUserPoints($user_id)
                ];
            } else {
                $response['message'] = 'Failed to award profile completion points';
            }
            break;
            
        case 'award_connection':
            // Award points for connecting with a match
            if (isset($_POST['match_id'])) {
                $match_id = $_POST['match_id'];
                $result = $points->awardConnectionPoints($user_id, $match_id);
                if ($result) {
                    $_SESSION['points_message'] = 'You earned points for connecting with a match!';
                    $_SESSION['points_amount'] = POINTS_CONNECT_MATCH;
                    $response['success'] = true;
                    $response['message'] = 'Connection points awarded';
                    $response['data'] = [
                        'points_awarded' => POINTS_CONNECT_MATCH,
                        'total_points' => $points->getUserPoints($user_id)
                    ];
                } else {
                    $response['message'] = 'Failed to award connection points';
                }
            } else {
                $response['message'] = 'Match ID not provided';
            }
            break;
            
        case 'award_innovation_need':
            // Award points for posting an innovation need (for corporate users)
            if (isset($_POST['need_id'])) {
                $need_id = $_POST['need_id'];
                $result = $points->awardInnovationNeedPoints($user_id, $need_id);
                if ($result) {
                    $_SESSION['points_message'] = 'You earned points for posting an innovation need!';
                    $_SESSION['points_amount'] = POINTS_POST_INNOVATION_NEED;
                    $response['success'] = true;
                    $response['message'] = 'Innovation need points awarded';
                    $response['data'] = [
                        'points_awarded' => POINTS_POST_INNOVATION_NEED,
                        'total_points' => $points->getUserPoints($user_id)
                    ];
                } else {
                    $response['message'] = 'Failed to award innovation need points';
                }
            } else {
                $response['message'] = 'Need ID not provided';
            }
            break;
            
        case 'award_solution':
            // Award points for submitting a solution (for startup users)
            if (isset($_POST['solution_id'])) {
                $solution_id = $_POST['solution_id'];
                $result = $points->awardSolutionPoints($user_id, $solution_id);
                if ($result) {
                    $_SESSION['points_message'] = 'You earned points for submitting a solution!';
                    $_SESSION['points_amount'] = POINTS_SUBMIT_SOLUTION;
                    $response['success'] = true;
                    $response['message'] = 'Solution points awarded';
                    $response['data'] = [
                        'points_awarded' => POINTS_SUBMIT_SOLUTION,
                        'total_points' => $points->getUserPoints($user_id)
                    ];
                } else {
                    $response['message'] = 'Failed to award solution points';
                }
            } else {
                $response['message'] = 'Solution ID not provided';
            }
            break;
            
        default:
            $response['message'] = 'Invalid action';
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the action from query string
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'get_points':
            // Get user's total points
            $total_points = $points->getUserPoints($user_id);
            $response['success'] = true;
            $response['data'] = [
                'total_points' => $total_points
            ];
            break;
            
        case 'get_history':
            // Get user's points history
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            
            $history = $points->getPointsHistory($user_id, $limit, $offset);
            $response['success'] = true;
            $response['data'] = [
                'history' => $history
            ];
            break;
            
        case 'get_level':
            // Get user's current level
            $level_info = $points->getUserLevel($user_id);
            $response['success'] = true;
            $response['data'] = $level_info;
            break;
            
        case 'get_leaderboard':
            // Get leaderboard
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
            $user_type = isset($_GET['user_type']) ? $_GET['user_type'] : null;
            
            $leaderboard = $points->getLeaderboard($limit, $user_type);
            $response['success'] = true;
            $response['data'] = [
                'leaderboard' => $leaderboard
            ];
            break;
            
        default:
            $response['message'] = 'Invalid action';
            break;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 