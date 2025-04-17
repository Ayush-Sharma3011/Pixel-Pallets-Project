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

// Check if rewards table exists
$stmt = $conn->prepare("SHOW TABLES LIKE 'rewards'");
$stmt->execute();
if ($stmt->rowCount() == 0) {
    // Rewards table doesn't exist, redirect to setup
    header("Location: setup.php");
    exit();
}

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

// Filter and sorting parameters
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Get rewards with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 9;
$offset = ($page - 1) * $records_per_page;

$available_rewards = $rewardsSystem->getAvailableRewards($user_type, $category, $sort, $records_per_page, $offset);
$total_rewards = $rewardsSystem->countAvailableRewards($user_type, $category);
$total_pages = ceil($total_rewards / $records_per_page);

// Get categories for filter
$categories = $rewardsSystem->getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards Center - Biz-Fusion</title>
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
                <a href="redemption-history.php" class="hover:text-primary transition">Redemption History</a>
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
                <h1 class="text-3xl font-bold mb-2">Rewards Center</h1>
                <p class="text-gray-400">Exchange your points for exciting rewards</p>
            </div>
            <div class="flex items-center mt-4 md:mt-0">
                <div class="bg-primary bg-opacity-20 p-4 rounded-xl flex items-center">
                    <i class="fas fa-coins text-yellow-300 text-xl mr-2"></i>
                    <div>
                        <div class="text-xl font-bold"><?php echo number_format($total_points); ?></div>
                        <div class="text-xs text-gray-400">Your Points</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-dark bg-opacity-50 rounded-xl p-6 mb-8">
            <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-400 mb-2">Category</label>
                    <select name="category" id="category" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white">
                        <option value="all" <?php echo $category === 'all' ? 'selected' : ''; ?>>All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $category === $cat ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-400 mb-2">Sort By</label>
                    <select name="sort" id="sort" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white">
                        <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="points_asc" <?php echo $sort === 'points_asc' ? 'selected' : ''; ?>>Points: Low to High</option>
                        <option value="points_desc" <?php echo $sort === 'points_desc' ? 'selected' : ''; ?>>Points: High to Low</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-lg transition w-full">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Rewards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <?php if (count($available_rewards) > 0): ?>
                <?php foreach ($available_rewards as $reward): ?>
                    <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition">
                        <div class="bg-primary bg-opacity-10 p-6 flex justify-center">
                            <div class="w-24 h-24 bg-primary bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-gift text-primary text-4xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-2">
                                <span class="bg-primary bg-opacity-20 text-primary px-3 py-1 rounded-full text-xs mr-2">
                                    <?php echo htmlspecialchars($reward['category']); ?>
                                </span>
                                <?php if ($reward['quantity'] && $reward['quantity'] < 10): ?>
                                    <span class="bg-red-500 bg-opacity-20 text-red-400 px-3 py-1 rounded-full text-xs">
                                        Only <?php echo $reward['quantity']; ?> left
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($reward['title']); ?></h3>
                            <p class="text-gray-400 text-sm mb-4"><?php echo substr(htmlspecialchars($reward['description']), 0, 100) . '...'; ?></p>
                            
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                                    <span class="font-semibold"><?php echo number_format($reward['points_required']); ?></span>
                                </div>
                                <?php if ($total_points >= $reward['points_required']): ?>
                                    <a href="redeem.php?id=<?php echo $reward['id']; ?>" class="bg-secondary hover:bg-opacity-90 text-white px-4 py-2 rounded-full transition text-sm">
                                        Redeem Now
                                    </a>
                                <?php else: ?>
                                    <div class="text-gray-500 text-sm">
                                        <i class="fas fa-lock mr-1"></i> Not enough points
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-search text-gray-500 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">No Rewards Found</h3>
                    <p class="text-gray-400">No rewards match your current filters. Please try different criteria.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="flex justify-center mt-8">
                <div class="flex space-x-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&category=<?php echo $category; ?>&sort=<?php echo $sort; ?>" class="bg-dark bg-opacity-70 hover:bg-opacity-100 px-4 py-2 rounded-lg transition">
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
                        <a href="?page=<?php echo $i; ?>&category=<?php echo $category; ?>&sort=<?php echo $sort; ?>" class="px-4 py-2 rounded-lg transition <?php echo ($i == $page) ? 'bg-primary text-white' : 'bg-dark bg-opacity-70 hover:bg-opacity-100'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&category=<?php echo $category; ?>&sort=<?php echo $sort; ?>" class="bg-dark bg-opacity-70 hover:bg-opacity-100 px-4 py-2 rounded-lg transition">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
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
