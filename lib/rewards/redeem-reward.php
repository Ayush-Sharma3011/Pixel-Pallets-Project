<?php
/**
 * Redeem Reward
 * 
 * This script handles reward redemption requests.
 */

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $response = [
        'success' => false,
        'message' => 'You must be logged in to redeem rewards.'
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Include necessary files
require_once '../db/config.php';
require_once 'RewardsSystem.php';

// Check if request is AJAX and POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    $response = [
        'success' => false,
        'message' => 'Invalid request method.'
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Get reward ID from POST data
$reward_id = filter_input(INPUT_POST, 'reward_id', FILTER_SANITIZE_NUMBER_INT);

if (empty($reward_id)) {
    $response = [
        'success' => false,
        'message' => 'Invalid reward selected.'
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Initialize Rewards System
$rewardsSystem = new RewardsSystem($mysqli);

// Attempt to redeem the reward
$result = $rewardsSystem->redeemReward($user_id, $reward_id);

// Set points message if redemption was successful
if ($result['success']) {
    $_SESSION['points_message'] = "You redeemed {$result['reward']} for {$result['points_spent']} points!";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($result);
exit; 