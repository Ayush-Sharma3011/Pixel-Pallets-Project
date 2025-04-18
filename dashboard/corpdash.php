<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has the correct user type
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_type'] !== 'corporate') {
    header("Location: ../login.php");
    exit;
}

// Include database connection
require_once '../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Get user data
$user_id = $_SESSION['id'];
$username = $_SESSION['username'] ?? '';
$company_name = '';
$total_points = $_SESSION['total_points'] ?? 0;

// Get corporate profile data
try {
    $stmt = $conn->prepare("SELECT * FROM corporate_profiles WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        $company_name = $profile['company_name'] ?? $username;
    }
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching corporate profile: " . $e->getMessage());
}

// Get active innovation needs
$innovation_needs = [];
try {
    $stmt = $conn->prepare("SELECT * FROM innovation_needs WHERE corporate_id = :corporate_id AND status = 'active' ORDER BY created_at DESC LIMIT 3");
    $stmt->bindParam(':corporate_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $innovation_needs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching innovation needs: " . $e->getMessage());
}

// Get startup matches count
$matches_count = 0;
try {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM partnerships WHERE corporate_id = :corporate_id");
    $stmt->bindParam(':corporate_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $matches_count = $result['count'];
    }
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching matches count: " . $e->getMessage());
}

// Get user initials for the avatar
$initials = "";
if (!empty($company_name)) {
    $words = explode(" ", $company_name);
    foreach ($words as $word) {
        $initials .= $word[0];
    }
    $initials = strtoupper(substr($initials, 0, 2));
} else {
    $initials = "GC"; // Default
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Dashboard - Biz-Fusion</title>
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
                <a href="../index.php">
                    <img src="../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="corpdash.php" class="text-secondary transition">Dashboard</a>
                <a href="corporate-innovation.php" class="hover:text-secondary transition">Innovation Needs</a>
                <a href="corporate-discovery.php" class="hover:text-secondary transition">Startup Discovery</a>
                <a href="corporate-messages.php" class="hover:text-secondary transition">Messages</a>
                <a href="corporate-profile.php" class="hover:text-secondary transition">Profile</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-white hover:text-secondary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center">
                        <span class="font-semibold text-sm"><?php echo $initials; ?></span>
                    </div>
                    <span><?php echo htmlspecialchars($company_name); ?></span>
                </div>
                <a href="../logout.php" class="text-sm text-gray-400 hover:text-white">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="font-['Playfair_Display'] text-3xl font-bold mb-2">Corporate Dashboard</h1>
                <p class="text-gray-300">Welcome back, <?php echo htmlspecialchars($company_name); ?>! Here's your innovation overview.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <a href="corporate-innovation.php?action=new" class="bg-secondary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Post Innovation Need</a>
                <a href="corporate-analytics.php" class="border border-secondary text-secondary hover:bg-secondary hover:bg-opacity-10 px-6 py-2 rounded-full transition">View Analytics</a>
            </div>
        </div>
    </section>

    <!-- Dashboard Stats -->
    <section class="container mx-auto px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Active Innovation Needs</h3>
                </div>
                <p class="text-3xl font-bold"><?php echo count($innovation_needs); ?></p>
                <p class="text-sm text-gray-400 mt-2">Open challenges seeking solutions</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Startup Matches</h3>
                    <span class="bg-secondary bg-opacity-20 text-secondary px-2 py-1 rounded text-sm">+8 this week</span>
                </div>
                <p class="text-3xl font-bold"><?php echo $matches_count; ?></p>
                <p class="text-sm text-gray-400 mt-2">Potential innovation partners</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Active Discussions</h3>
                </div>
                <p class="text-3xl font-bold">7</p>
                <p class="text-sm text-gray-400 mt-2">Ongoing conversations</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Points Earned</h3>
                </div>
                <p class="text-3xl font-bold"><?php echo $total_points; ?></p>
                <p class="text-sm text-gray-400 mt-2">Redeem for rewards</p>
            </div>
        </div>
    </section>

    <!-- Innovation Needs -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-['Playfair_Display'] font-bold">Your Innovation Needs</h2>
            <a href="corporate-innovation.php" class="text-secondary hover:underline text-sm">View All</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php if (count($innovation_needs) > 0): 
                foreach ($innovation_needs as $need): ?>
                <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                    <div class="h-2 bg-green-500"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($need['title']); ?></h3>
                            <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">Active</span>
                        </div>
                        <p class="text-gray-300 text-sm mb-4"><?php echo htmlspecialchars(substr($need['description'], 0, 100)) . '...'; ?></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php
                            $categories = explode(',', $need['categories']);
                            $colors = ['blue', 'purple', 'pink', 'red', 'orange', 'yellow', 'green'];
                            foreach ($categories as $index => $category): 
                                $color = $colors[$index % count($colors)];
                            ?>
                            <span class="bg-<?php echo $color; ?>-500 bg-opacity-20 text-<?php echo $color; ?>-400 px-2 py-1 rounded text-xs"><?php echo htmlspecialchars(trim($category)); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">12 matches</span>
                            <a href="corporate-innovation.php?id=<?php echo $need['id']; ?>" class="text-secondary hover:underline text-sm">View Matches</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="col-span-3 bg-dark bg-opacity-50 rounded-xl p-8 text-center">
                    <p class="text-gray-300 mb-4">You don't have any active innovation needs yet.</p>
                    <a href="corporate-innovation.php?action=new" class="inline-block bg-secondary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Post Your First Innovation Need</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-8 mt-16">
        <div class="container mx-auto px-6">
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; <?php echo date('Y'); ?> Biz-Fusion. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Dashboard functionality goes here
    </script>
</body>
</html>