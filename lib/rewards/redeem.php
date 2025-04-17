<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit();
}

// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Include rewards system
require_once 'RewardsSystem.php';
$rewardsSystem = new RewardsSystem($conn);

// Include points system
require_once '../points/PointsSystem.php';
$pointsSystem = new PointsSystem($conn);

// Get user data
$user_id = $_SESSION["id"];
$user_type = $_SESSION["user_type"];
$total_points = $pointsSystem->getUserPoints($user_id);

// Initialize variables
$reward = null;
$reward_id = null;
$error_message = '';
$success_message = '';

// Check if reward ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $reward_id = $_GET['id'];
    $reward = $rewardsSystem->getRewardById($reward_id);
    
    // Check if reward exists and is available for the user's type
    if (!$reward) {
        $error_message = 'Reward not found.';
    } elseif ($reward['user_type'] !== 'all' && $reward['user_type'] !== $user_type) {
        $error_message = 'This reward is not available for your account type.';
    } elseif ($reward['status'] !== 'active') {
        $error_message = 'This reward is currently not available.';
    } elseif ($total_points < $reward['points_required']) {
        $error_message = 'You don\'t have enough points to redeem this reward.';
    }
} else {
    $error_message = 'Invalid reward selection.';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_redemption']) && !empty($reward_id)) {
    // Double-check all conditions
    if ($reward && 
        ($reward['user_type'] === 'all' || $reward['user_type'] === $user_type) && 
        $reward['status'] === 'active' && 
        $total_points >= $reward['points_required']) {
        
        // Attempt to redeem the reward
        try {
            $redemption_id = $rewardsSystem->redeemReward($user_id, $reward_id, $reward['points_required']);
            
            if ($redemption_id) {
                // Update the user's points
                $total_points = $pointsSystem->getUserPoints($user_id);
                $success_message = 'Reward redeemed successfully!';
            } else {
                $error_message = 'Failed to redeem reward. Please try again.';
            }
        } catch (Exception $e) {
            $error_message = 'An error occurred: ' . $e->getMessage();
        }
    } else {
        $error_message = 'Invalid redemption request.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Reward - Biz-Fusion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        dark: '#0A0F1D',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-['Poppins'] bg-gradient-to-t from-[#0A0F1D] to-[#000000] text-white min-h-screen">
    <!-- Navigation -->
    <nav class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="../../index.php">
                    <img src="../../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="../../dashboard/<?php echo $user_type; ?>.php" class="hover:text-primary transition">Dashboard</a>
                <a href="index.php" class="hover:text-primary transition">Rewards Center</a>
                <a href="../../dashboard/profile.php" class="hover:text-primary transition">Profile</a>
            </div>
            <div>
                <a href="../../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full transition">Sign Out</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <a href="index.php" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Rewards
        </a>

        <?php if ($error_message): ?>
            <div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-300 px-6 py-4 rounded-lg mb-8">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-xl mr-2"></i>
                    <div>
                        <h3 class="font-semibold">Error</h3>
                        <p><?php echo $error_message; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="text-center p-8">
                <a href="index.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-lg transition">
                    Return to Rewards Center
                </a>
            </div>
        <?php elseif ($success_message): ?>
            <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-300 px-6 py-4 rounded-lg mb-8">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl mr-2"></i>
                    <div>
                        <h3 class="font-semibold">Success</h3>
                        <p><?php echo $success_message; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden shadow-xl p-8 text-center">
                <i class="fas fa-gift text-primary text-5xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-4">Reward Redeemed!</h2>
                <p class="mb-6 text-gray-400">Your reward has been successfully redeemed and is now being processed.</p>
                
                <div class="mb-8 py-6 bg-primary bg-opacity-10 rounded-lg">
                    <div class="text-sm text-gray-400 mb-2">Your remaining balance</div>
                    <div class="flex items-center justify-center">
                        <i class="fas fa-coins text-yellow-300 text-2xl mr-2"></i>
                        <span class="text-3xl font-bold"><?php echo number_format($total_points); ?> points</span>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="redemption-history.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-lg transition">
                        <i class="fas fa-history mr-2"></i> View Redemption History
                    </a>
                    <a href="index.php" class="bg-dark hover:bg-opacity-90 text-white border border-gray-700 px-6 py-3 rounded-lg transition">
                        <i class="fas fa-gift mr-2"></i> Browse More Rewards
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden shadow-xl">
                <div class="md:flex">
                    <!-- Reward Image -->
                    <div class="md:w-1/3 bg-primary bg-opacity-10 p-8 flex items-center justify-center">
                        <div class="w-48 h-48 bg-primary bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-gift text-primary text-6xl"></i>
                        </div>
                    </div>
                    
                    <!-- Reward Details -->
                    <div class="md:w-2/3 p-8">
                        <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($reward['title']); ?></h2>
                        <div class="flex items-center mb-4">
                            <div class="flex items-center bg-primary bg-opacity-20 text-primary px-3 py-1 rounded-full text-sm mr-3">
                                <i class="fas fa-coins text-yellow-300 mr-1"></i>
                                <?php echo number_format($reward['points_required']); ?> points
                            </div>
                            <?php if ($reward['quantity'] && $reward['quantity'] < 10): ?>
                                <div class="flex items-center bg-red-500 bg-opacity-20 text-red-400 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Only <?php echo $reward['quantity']; ?> left
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-6 text-gray-400">
                            <?php echo nl2br(htmlspecialchars($reward['description'])); ?>
                        </div>
                        
                        <div class="border-t border-gray-700 pt-6 mt-6">
                            <h3 class="text-xl font-semibold mb-4">Confirm Redemption</h3>
                            
                            <div class="bg-gradient-to-r from-primary to-secondary bg-opacity-20 rounded-lg p-6 mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-sm text-gray-400">Your Balance</div>
                                    <div class="font-bold text-2xl flex items-center">
                                        <i class="fas fa-coins text-yellow-300 mr-2"></i>
                                        <?php echo number_format($total_points); ?>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-sm text-gray-400">Reward Cost</div>
                                    <div class="font-bold text-2xl text-red-400">
                                        -<?php echo number_format($reward['points_required']); ?>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-600 pt-4">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-400">Remaining Balance</div>
                                        <div class="font-bold text-2xl text-green-400">
                                            <?php echo number_format($total_points - $reward['points_required']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form method="post" class="mt-6">
                                <div class="mb-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 mr-2">
                                        <label for="terms" class="text-gray-400">I understand that this action cannot be undone after the reward is processed.</label>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                    <button type="submit" name="confirm_redemption" class="bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-lg transition">
                                        <i class="fas fa-check-circle mr-2"></i> Confirm Redemption
                                    </button>
                                    <a href="index.php" class="text-center bg-dark hover:bg-opacity-90 text-white border border-gray-700 px-6 py-3 rounded-lg transition">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-8 mt-12">
        <div class="container mx-auto px-6">
            <div class="text-center text-gray-500">
                <p>&copy; <?php echo date('Y'); ?> Biz-Fusion. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 