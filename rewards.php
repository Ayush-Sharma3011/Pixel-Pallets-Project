<?php
session_start();
require_once 'config.php';
require_once 'points_system.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];
$total_points = $_SESSION['total_points'];

// Handle reward redemption
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['redeem_reward'])) {
    $reward_id = $_POST['reward_id'];
    
    // Verify reward exists and user has enough points
    $stmt = $conn->prepare("SELECT id, name, points_required FROM rewards WHERE id = ? AND is_active = 1");
    $stmt->bind_param("i", $reward_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $reward = $result->fetch_assoc();
        
        if ($total_points >= $reward['points_required']) {
            // Deduct points from user
            $deductStmt = $conn->prepare("UPDATE users SET total_points = total_points - ? WHERE id = ?");
            $deductStmt->bind_param("ii", $reward['points_required'], $user_id);
            $deductStmt->execute();
            
            // Log the points deduction
            $pointsSystem = new PointsSystem($conn);
            $activity = "Redeemed reward: " . $reward['name'];
            $pointsSystem->awardPoints($user_id, -$reward['points_required'], $activity);
            
            // Record the redemption
            $redeemStmt = $conn->prepare("INSERT INTO user_rewards (user_id, reward_id) VALUES (?, ?)");
            $redeemStmt->bind_param("ii", $user_id, $reward_id);
            $redeemStmt->execute();
            
            // Update session points
            $_SESSION['total_points'] -= $reward['points_required'];
            $total_points = $_SESSION['total_points'];
            
            $_SESSION['reward_success'] = "You have successfully redeemed the reward: " . $reward['name'];
        } else {
            $_SESSION['reward_error'] = "You don't have enough points to redeem this reward.";
        }
    } else {
        $_SESSION['reward_error'] = "Invalid reward selection.";
    }
}

// Get available rewards
$rewardsStmt = $conn->prepare("SELECT id, name, description, points_required FROM rewards WHERE is_active = 1 ORDER BY points_required ASC");
$rewardsStmt->execute();
$rewardsResult = $rewardsStmt->get_result();

// Get user's redeemed rewards
$redeemedStmt = $conn->prepare("
    SELECT r.name, r.description, ur.redeemed_date, ur.status 
    FROM user_rewards ur
    JOIN rewards r ON ur.reward_id = r.id
    WHERE ur.user_id = ?
    ORDER BY ur.redeemed_date DESC
");
$redeemedStmt->bind_param("i", $user_id);
$redeemedStmt->execute();
$redeemedResult = $redeemedStmt->get_result();

// Get points history
$pointsSystem = new PointsSystem($conn);
$pointsHistory = $pointsSystem->getPointsHistory($user_id, 5);

// Get leaderboard
$leaderboard = $pointsSystem->getLeaderboard(5);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards - Biz-Fusion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
                <a href="index.html">
                    <img src="bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <?php if ($user_type == 'startup'): ?>
                    <a href="startup-dashboard.html" class="hover:text-primary transition">Dashboard</a>
                <?php else: ?>
                    <a href="corporate-dashboard.html" class="hover:text-primary transition">Dashboard</a>
                <?php endif; ?>
                <a href="#" class="text-primary transition">Rewards</a>
                <a href="profile.php" class="hover:text-primary transition">Profile</a>
            </div>
            <div class="flex items-center">
                <div class="mr-4 bg-dark bg-opacity-50 px-4 py-2 rounded-full">
                    <span class="text-yellow-400 font-semibold"><?php echo $total_points; ?></span> points
                </div>
                <a href="logout.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign Out</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Alerts -->
        <?php if (isset($_SESSION['reward_success'])): ?>
            <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-500 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['reward_success']; ?>
                <?php unset($_SESSION['reward_success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['reward_error'])): ?>
            <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-500 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['reward_error']; ?>
                <?php unset($_SESSION['reward_error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['points_message'])): ?>
            <div class="bg-blue-500 bg-opacity-20 border border-blue-500 text-blue-500 px-4 py-3 rounded mb-6">
                <?php echo $_SESSION['points_message']; ?>
                <?php unset($_SESSION['points_message']); ?>
            </div>
        <?php endif; ?>
        
        <h1 class="font-['Playfair_Display'] text-4xl font-bold mb-8">Rewards Center</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Available Rewards -->
            <div class="lg:col-span-2">
                <div class="bg-dark bg-opacity-50 rounded-xl p-6 mb-8">
                    <h2 class="text-2xl font-semibold mb-6">Available Rewards</h2>
                    
                    <?php if ($rewardsResult->num_rows > 0): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php while ($reward = $rewardsResult->fetch_assoc()): ?>
                                <div class="bg-dark bg-opacity-70 rounded-lg p-6 border border-gray-800">
                                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($reward['name']); ?></h3>
                                    <p class="text-gray-300 mb-4"><?php echo htmlspecialchars($reward['description']); ?></p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-yellow-400 font-semibold"><?php echo $reward['points_required']; ?> points</span>
                                        <form method="post" action="">
                                            <input type="hidden" name="reward_id" value="<?php echo $reward['id']; ?>">
                                            <button type="submit" name="redeem_reward" 
                                                class="<?php echo ($total_points >= $reward['points_required']) ? 'bg-primary hover:bg-opacity-90' : 'bg-gray-700 cursor-not-allowed'; ?> text-white px-4 py-2 rounded-lg transition"
                                                <?php echo ($total_points >= $reward['points_required']) ? '' : 'disabled'; ?>>
                                                Redeem
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-400">No rewards available at the moment.</p>
                    <?php endif; ?>
                </div>
                
                <!-- Redeemed Rewards -->
                <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                    <h2 class="text-2xl font-semibold mb-6">Your Redeemed Rewards</h2>
                    
                    <?php if ($redeemedResult->num_rows > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-800">
                                        <th class="text-left py-3 px-4">Reward</th>
                                        <th class="text-left py-3 px-4">Date Redeemed</th>
                                        <th class="text-left py-3 px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($redeemed = $redeemedResult->fetch_assoc()): ?>
                                        <tr class="border-b border-gray-800">
                                            <td class="py-3 px-4">
                                                <div class="font-semibold"><?php echo htmlspecialchars($redeemed['name']); ?></div>
                                                <div class="text-sm text-gray-400"><?php echo htmlspecialchars($redeemed['description']); ?></div>
                                            </td>
                                            <td class="py-3 px-4"><?php echo date('M d, Y', strtotime($redeemed['redeemed_date'])); ?></td>
                                            <td class="py-3 px-4">
                                                <span class="<?php echo ($redeemed['status'] == 'completed') ? 'bg-green-500' : 'bg-yellow-500'; ?> bg-opacity-20 text-xs font-semibold px-2 py-1 rounded-full">
                                                    <?php echo ucfirst($redeemed['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-400">You haven't redeemed any rewards yet.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right Column: Points Info and Leaderboard -->
            <div>
                <!-- Points Summary -->
                <div class="bg-dark bg-opacity-50 rounded-xl p-6 mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Your Points</h2>
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-gray-300">Total Points:</span>
                        <span class="text-3xl font-bold text-yellow-400"><?php echo $total_points; ?></span>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-3">Recent Activity</h3>
                    <?php if (!empty($pointsHistory)): ?>
                        <ul class="space-y-3">
                            <?php foreach ($pointsHistory as $entry): ?>
                                <li class="flex justify-between items-center">
                                    <span class="text-sm text-gray-300"><?php echo htmlspecialchars($entry['activity']); ?></span>
                                    <span class="<?php echo ($entry['points'] > 0) ? 'text-green-500' : 'text-red-500'; ?> font-semibold">
                                        <?php echo ($entry['points'] > 0) ? '+' : ''; ?><?php echo $entry['points']; ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-400">No recent activity.</p>
                    <?php endif; ?>
                </div>
                
                <!-- Leaderboard -->
                <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                    <h2 class="text-2xl font-semibold mb-4">Leaderboard</h2>
                    
                    <?php if (!empty($leaderboard)): ?>
                        <ul class="space-y-4">
                            <?php foreach ($leaderboard as $index => $user): ?>
                                <li class="flex items-center">
                                    <div class="w-8 h-8 bg-primary bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold"><?php echo htmlspecialchars($user['username']); ?></div>
                                        <div class="text-xs text-gray-400"><?php echo ucfirst($user['user_type']); ?></div>
                                    </div>
                                    <div class="text-yellow-400 font-semibold"><?php echo $user['total_points']; ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-400">No users on the leaderboard yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-8 mt-16">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-500">&copy; 2023 Biz-Fusion. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 