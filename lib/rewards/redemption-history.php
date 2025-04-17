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

// Get user's redemption history with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

$redemption_history = $rewardsSystem->getUserRedemptionHistory($user_id, $records_per_page, $offset);
$total_records = $rewardsSystem->countUserRedemptions($user_id);
$total_pages = ceil($total_records / $records_per_page);

// Handle cancellation request
$message = '';
$message_type = '';

if (isset($_POST['cancel_redemption']) && isset($_POST['redemption_id'])) {
    $redemption_id = $_POST['redemption_id'];
    
    try {
        // Check if redemption belongs to user and is in pending status
        $redemption = $rewardsSystem->getRedemptionById($redemption_id);
        
        if ($redemption && $redemption['user_id'] == $user_id && $redemption['status'] == 'pending') {
            $result = $rewardsSystem->cancelRedemption($redemption_id);
            
            if ($result) {
                $message = 'Redemption cancelled successfully. Your points have been refunded.';
                $message_type = 'success';
                // Refresh redemption history after cancellation
                $redemption_history = $rewardsSystem->getUserRedemptionHistory($user_id, $records_per_page, $offset);
                $total_points = $pointsSystem->getUserPoints($user_id);
            } else {
                $message = 'Failed to cancel redemption. Please try again.';
                $message_type = 'error';
            }
        } else {
            $message = 'Invalid redemption or cannot be cancelled at this time.';
            $message_type = 'error';
        }
    } catch (Exception $e) {
        $message = 'An error occurred: ' . $e->getMessage();
        $message_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redemption History - Biz-Fusion</title>
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
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold mb-2">Redemption History</h1>
                <p class="text-gray-400">Track the status of all your reward redemptions</p>
            </div>
            <div class="flex items-center mt-4 md:mt-0">
                <div class="bg-primary bg-opacity-20 p-4 rounded-xl flex items-center mr-4">
                    <i class="fas fa-coins text-yellow-300 text-xl mr-2"></i>
                    <div>
                        <div class="text-xl font-bold"><?php echo number_format($total_points); ?></div>
                        <div class="text-xs text-gray-400">Current Points</div>
                    </div>
                </div>
                <a href="index.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Rewards
                </a>
            </div>
        </div>

        <!-- Notification -->
        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo ($message_type === 'success') ? 'bg-green-600 bg-opacity-20 text-green-300' : 'bg-red-600 bg-opacity-20 text-red-300'; ?>">
                <div class="flex items-center">
                    <i class="<?php echo ($message_type === 'success') ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-circle text-red-400'; ?> text-xl mr-2"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Redemption History Table -->
        <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden shadow-xl">
            <?php if (empty($redemption_history)): ?>
                <div class="p-8 text-center">
                    <i class="fas fa-history text-gray-500 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">No Redemption History</h3>
                    <p class="text-gray-400 mb-6">You haven't redeemed any rewards yet.</p>
                    <a href="index.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-lg transition">
                        Browse Available Rewards
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-primary bg-opacity-20 text-left">
                                <th class="px-6 py-4 font-semibold">Reward</th>
                                <th class="px-6 py-4 font-semibold">Date</th>
                                <th class="px-6 py-4 font-semibold">Points Spent</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($redemption_history as $redemption): ?>
                                <tr class="hover:bg-dark hover:bg-opacity-70 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-primary bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-gift text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium"><?php echo htmlspecialchars($redemption['title']); ?></div>
                                                <div class="text-xs text-gray-400">#<?php echo $redemption['id']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div><?php echo date('M j, Y', strtotime($redemption['redemption_date'])); ?></div>
                                        <div class="text-xs text-gray-400"><?php echo date('h:i A', strtotime($redemption['redemption_date'])); ?></div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-red-400">
                                        -<?php echo number_format($redemption['points_spent']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 text-xs rounded-full font-medium
                                            <?php 
                                            switch($redemption['status']) {
                                                case 'pending': echo 'bg-yellow-500 bg-opacity-20 text-yellow-400'; break;
                                                case 'completed': echo 'bg-green-500 bg-opacity-20 text-green-400'; break;
                                                case 'cancelled': echo 'bg-red-500 bg-opacity-20 text-red-400'; break;
                                            }
                                            ?>">
                                            <?php echo ucfirst($redemption['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($redemption['status'] === 'pending'): ?>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to cancel this redemption? Your points will be refunded.')">
                                                <input type="hidden" name="redemption_id" value="<?php echo $redemption['id']; ?>">
                                                <button type="submit" name="cancel_redemption" class="text-red-500 hover:text-red-400 transition">
                                                    <i class="fas fa-times-circle mr-1"></i> Cancel
                                                </button>
                                            </form>
                                        <?php elseif ($redemption['status'] === 'completed'): ?>
                                            <span class="text-gray-500">
                                                <i class="fas fa-check-circle mr-1"></i> Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-500">
                                                <i class="fas fa-ban mr-1"></i> Cancelled
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="px-6 py-4 bg-dark bg-opacity-50 border-t border-gray-700">
                        <div class="flex justify-between items-center">
                            <div class="text-gray-400 text-sm">
                                Showing <?php echo $offset + 1; ?> - <?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> records
                            </div>
                            <div class="flex space-x-2">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>" class="bg-dark bg-opacity-70 hover:bg-opacity-100 px-4 py-2 rounded-lg transition">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php
                                $start_page = max(1, $page - 2);
                                $end_page = min($total_pages, $start_page + 4);
                                if ($end_page - $start_page < 4) {
                                    $start_page = max(1, $end_page - 4);
                                }
                                
                                for ($i = $start_page; $i <= $end_page; $i++):
                                ?>
                                    <a href="?page=<?php echo $i; ?>" class="px-4 py-2 rounded-lg transition <?php echo ($i == $page) ? 'bg-primary text-white' : 'bg-dark bg-opacity-70 hover:bg-opacity-100'; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>" class="bg-dark bg-opacity-70 hover:bg-opacity-100 px-4 py-2 rounded-lg transition">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
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