<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== "startup") {
    header("location: ../login.php");
    exit;
}

// Include database connection
require_once '../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Get user data
$user_id = $_SESSION["id"];
$stmt = $conn->prepare("SELECT u.*, sp.* FROM users u 
                        LEFT JOIN startup_profiles sp ON u.id = sp.user_id 
                        WHERE u.id = :user_id");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get innovation needs (opportunities)
$stmt = $conn->prepare("SELECT * FROM innovation_needs WHERE status = 'active' ORDER BY created_at DESC LIMIT 5");
$stmt->execute();
$opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get matched partnerships
$stmt = $conn->prepare("SELECT p.*, u.company_name, u.industry 
                       FROM partnerships p 
                       JOIN users u ON p.corporate_id = u.id 
                       WHERE p.startup_id = :user_id");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$partnerships = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Dashboard - Biz-Fusion</title>
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
    <nav class="bg-dark bg-opacity-90 py-4 shadow-md">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <a href="../index.php">
                    <img src="../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-8">
                </a>
                <span class="ml-3 text-lg font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="startdash.php" class="hover:text-primary transition">Dashboard</a>
                <a href="../lib/rewards/index.php" class="hover:text-primary transition">Rewards Center</a>
                <a href="profile.php" class="hover:text-primary transition">Profile</a>
                <a href="connect.php" class="hover:text-primary transition">Connect</a>
                <a href="messages.php" class="hover:text-primary transition">Messages</a>
            </div>
            <div class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-300 hover:text-primary transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </a>
                <div class="relative">
                    <button class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                            <?php echo substr($user['username'], 0, 1); ?>
                        </div>
                        <span><?php echo htmlspecialchars($user['username']); ?></span>
                    </button>
                </div>
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 container mx-auto px-6">
            <div class="flex flex-col space-y-4 bg-gray-800 bg-opacity-80 p-4 rounded-lg">
                <a href="startdash.php" class="hover:text-primary transition">Dashboard</a>
                <a href="../lib/rewards/index.php" class="hover:text-primary transition">Rewards Center</a>
                <a href="profile.php" class="hover:text-primary transition">Profile</a>
                <a href="connect.php" class="hover:text-primary transition">Connect</a>
                <a href="messages.php" class="hover:text-primary transition">Messages</a>
                
                <div class="pt-2 border-t border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                            <?php echo substr($user['username'], 0, 1); ?>
                        </div>
                        <span><?php echo htmlspecialchars($user['username']); ?></span>
                    </div>
                    <a href="#" class="text-gray-300 hover:text-primary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- JavaScript for mobile menu toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>

    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Startup Dashboard</h1>
            <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition">Logout</a>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Column - Profile -->
            <div class="md:col-span-1">
                <div class="bg-dark bg-opacity-50 rounded-xl p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-2xl font-bold mr-4">
                            <?php echo substr($user['username'], 0, 1); ?>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($user['company_name']); ?></h2>
                            <p class="text-gray-400"><?php echo htmlspecialchars($user['industry']); ?></p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Profile Completion</h3>
                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                            <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo $user['profile_completion']; ?>%"></div>
                        </div>
                        <p class="text-xs text-right mt-1"><?php echo $user['profile_completion']; ?>%</p>
                    </div>
                    <a href="profile.php" class="block text-center bg-gray-800 hover:bg-gray-700 py-2 rounded-lg transition">Edit Profile</a>
                </div>

                <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                    <h3 class="font-semibold mb-4">Points & Rewards</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span>Current Points</span>
                        <span class="font-bold text-primary"><?php echo $user['total_points']; ?></span>
                    </div>
                    <a href="../lib/rewards/index.php" class="block text-center bg-primary hover:bg-opacity-90 py-2 rounded-lg transition">View Rewards</a>
                </div>
            </div>

            <!-- Middle Column - Opportunities -->
            <div class="md:col-span-2">
                <div class="bg-dark bg-opacity-50 rounded-xl p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Corporate Opportunities</h2>
                    
                    <?php if (count($opportunities) > 0): ?>
                        <div class="space-y-4">
                            <?php foreach ($opportunities as $opportunity): ?>
                                <div class="bg-gray-800 bg-opacity-60 p-4 rounded-lg hover:bg-opacity-80 transition">
                                    <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($opportunity['title']); ?></h3>
                                    <p class="text-gray-400 text-sm mb-2"><?php echo htmlspecialchars($opportunity['categories']); ?></p>
                                    <p class="text-sm mb-3"><?php echo substr(htmlspecialchars($opportunity['description']), 0, 150) . '...'; ?></p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-400">Posted <?php echo date('M j, Y', strtotime($opportunity['created_at'])); ?></span>
                                        <a href="submit-solution.php?id=<?php echo $opportunity['id']; ?>" class="bg-secondary hover:bg-opacity-90 text-white text-sm py-1 px-3 rounded-full transition">Apply</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="opportunities.php" class="block text-center text-primary hover:underline mt-4">View All Opportunities</a>
                    <?php else: ?>
                        <p class="text-gray-400 text-center py-4">No opportunities available at this time.</p>
                    <?php endif; ?>
                </div>

                <!-- Partnerships -->
                <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                    <h2 class="text-xl font-semibold mb-4">Your Partnerships</h2>
                    
                    <?php if (count($partnerships) > 0): ?>
                        <div class="space-y-4">
                            <?php foreach ($partnerships as $partnership): ?>
                                <div class="bg-gray-800 bg-opacity-60 p-4 rounded-lg hover:bg-opacity-80 transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-semibold"><?php echo htmlspecialchars($partnership['company_name']); ?></h3>
                                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($partnership['industry']); ?></p>
                                        </div>
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            <?php 
                                                switch($partnership['status']) {
                                                    case 'pending':
                                                        echo 'bg-yellow-500 bg-opacity-20 text-yellow-300';
                                                        break;
                                                    case 'active':
                                                        echo 'bg-green-500 bg-opacity-20 text-green-300';
                                                        break;
                                                    case 'completed':
                                                        echo 'bg-blue-500 bg-opacity-20 text-blue-300';
                                                        break;
                                                    default:
                                                        echo 'bg-gray-500 bg-opacity-20 text-gray-300';
                                                }
                                            ?>">
                                            <?php echo ucfirst($partnership['status']); ?>
                                        </span>
                                    </div>
                                    <div class="mt-2 flex justify-between">
                                        <a href="partnership-details.php?id=<?php echo $partnership['id']; ?>" class="text-primary hover:underline text-sm">View Details</a>
                                        <a href="messages.php?partner_id=<?php echo $partnership['corporate_id']; ?>" class="text-secondary hover:underline text-sm">Message</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="partnerships.php" class="block text-center text-primary hover:underline mt-4">Manage All Partnerships</a>
                    <?php else: ?>
                        <p class="text-gray-400 text-center py-4">You don't have any partnerships yet.</p>
                        <a href="connect.php" class="block text-center bg-primary hover:bg-opacity-90 py-2 rounded-lg transition mt-2">Find Corporates to Connect</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 