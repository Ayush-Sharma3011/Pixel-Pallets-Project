<?php
/**
 * Redeem Reward
 * 
 * This script handles reward redemption requests.
 */

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

// Get reward ID from URL parameter
$reward_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];

// Initialize variables
$reward = [];
$message = '';
$status = '';

// Check if form is submitted for reward redemption
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redeem'])) {
    $result = $rewardsSystem->redeemReward($user_id, $reward_id);
    
    if ($result['success']) {
        $status = 'success';
        $message = $result['message'];
        $reward = $result['reward'];
    } else {
        $status = 'error';
        $message = $result['message'];
    }
} else {
    // Check if reward exists and is available
    $availability = $rewardsSystem->checkRewardAvailability($user_id, $reward_id);
    
    if ($availability['available']) {
        $reward = $availability['reward'];
    } else {
        $status = 'error';
        $message = $availability['message'];
    }
}

// Get user points
$stmt = $conn->prepare("SELECT total_points FROM users WHERE id = :user_id");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$total_points = $user['total_points'];
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
                <a href="index.php" class="text-primary transition">Rewards Center</a>
                <a href="../../dashboard/profile.php" class="hover:text-primary transition">Profile</a>
            </div>
            <div>
                <a href="../../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full transition">Sign Out</a>
            </div>
        </div>
    </nav>

    <!-- Points Display -->
    <div class="fixed bottom-6 right-6 bg-primary text-white rounded-full px-4 py-2 flex items-center shadow-lg">
        <i class="fas fa-coins mr-2"></i>
        <span class="font-semibold"><?php echo number_format($total_points); ?> Points</span>
    </div>

    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Redeem Reward</h1>
            <a href="index.php" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Rewards
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="mb-8 p-4 rounded-lg <?php echo $status === 'success' ? 'bg-green-500 bg-opacity-20 text-green-400' : 'bg-red-500 bg-opacity-20 text-red-400'; ?>">
                <p><?php echo $message; ?></p>
                <?php if ($status === 'success'): ?>
                    <p class="mt-2">You can view your redemption in your <a href="redemption-history.php" class="underline">Redemption History</a>.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($reward) && $status !== 'success'): ?>
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 flex justify-center items-center">
                        <?php if (!empty($reward['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($reward['image_url']); ?>" alt="<?php echo htmlspecialchars($reward['title']); ?>" class="max-w-full max-h-64 rounded-lg shadow-lg">
                        <?php else: ?>
                            <div class="w-64 h-64 bg-gray-700 rounded-lg flex items-center justify-center">
                                <i class="fas fa-gift text-6xl text-gray-500"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="md:col-span-2 p-6">
                        <h2 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($reward['title']); ?></h2>
                        <div class="bg-primary bg-opacity-20 text-primary inline-block px-4 py-1 rounded-full font-semibold mb-4">
                            <?php echo number_format($reward['points_cost']); ?> Points
                        </div>
                        
                        <?php if (isset($reward['quantity']) && $reward['quantity'] > 0): ?>
                            <div class="bg-secondary bg-opacity-20 text-secondary inline-block px-4 py-1 rounded-full font-semibold mb-4 ml-2">
                                <?php echo $reward['quantity']; ?> Available
                            </div>
                        <?php endif; ?>
                        
                        <p class="text-gray-300 mb-6"><?php echo htmlspecialchars($reward['description']); ?></p>
                        
                        <?php if ($total_points >= $reward['points_cost']): ?>
                            <form method="post" action="">
                                <input type="hidden" name="reward_id" value="<?php echo $reward_id; ?>">
                                <button type="submit" name="redeem" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium transition">
                                    Redeem Reward
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="mb-4">
                                <p class="text-red-400 mb-2">You need <?php echo number_format($reward['points_cost'] - $total_points); ?> more points to redeem this reward.</p>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: <?php echo min(100, ($total_points / $reward['points_cost']) * 100); ?>%"></div>
                                </div>
                                <div class="flex justify-between mt-1 text-sm text-gray-400">
                                    <span>Your Points: <?php echo number_format($total_points); ?></span>
                                    <span>Required: <?php echo number_format($reward['points_cost']); ?></span>
                                </div>
                            </div>
                            <a href="../../dashboard/<?php echo $user_type; ?>.php" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition">
                                Earn More Points
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($status !== 'success'): ?>
                <div class="mt-8 bg-dark bg-opacity-30 rounded-xl p-6">
                    <h3 class="text-xl font-semibold mb-4">How to Earn More Points</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-20 p-2 rounded-full mr-3">
                                <i class="fas fa-sign-in-alt text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Daily Login</h4>
                                <p class="text-sm text-gray-400">Log in every day to earn 10 points</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-20 p-2 rounded-full mr-3">
                                <i class="fas fa-user-edit text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Complete Your Profile</h4>
                                <p class="text-sm text-gray-400">Earn 50 points for completing your profile</p>
                            </div>
                        </div>
                        <?php if ($user_type === 'startup'): ?>
                            <div class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full mr-3">
                                    <i class="fas fa-lightbulb text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Submit Solutions</h4>
                                    <p class="text-sm text-gray-400">Earn 25 points for each solution submission</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full mr-3">
                                    <i class="fas fa-search text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Post Innovation Needs</h4>
                                    <p class="text-sm text-gray-400">Earn 30 points for each innovation need posting</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-20 p-2 rounded-full mr-3">
                                <i class="fas fa-handshake text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Form Partnerships</h4>
                                <p class="text-sm text-gray-400">Earn 100 points for each successful partnership</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php elseif ($status !== 'success'): ?>
            <div class="bg-dark bg-opacity-50 rounded-xl p-8 text-center">
                <i class="fas fa-exclamation-circle text-4xl text-red-400 mb-4"></i>
                <h2 class="text-2xl font-semibold mb-2">Reward Not Found</h2>
                <p class="text-gray-300 mb-6">The reward you're looking for doesn't exist or is not available.</p>
                <a href="index.php" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium transition">
                    View Available Rewards
                </a>
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