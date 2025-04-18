<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has the correct user type
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_type'] !== 'startup') {
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
$profile_completion = 75; // Default value, will be calculated

// Get startup profile data
try {
    $stmt = $conn->prepare("SELECT * FROM startup_profiles WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        $company_name = $profile['company_name'] ?? $username;
        
        // Calculate profile completion
        $required_fields = ['company_size', 'founding_year', 'funding_stage', 'description', 'tags', 'website_url'];
        $completed_fields = 0;
        
        foreach ($required_fields as $field) {
            if (!empty($profile[$field])) {
                $completed_fields++;
            }
        }
        
        $profile_completion = round(($completed_fields / count($required_fields)) * 100);
    }
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching startup profile: " . $e->getMessage());
}

// Get matches count
$matches_count = 0;
try {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM partnerships WHERE startup_id = :startup_id");
    $stmt->bindParam(':startup_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $matches_count = $result['count'];
    }
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching matches count: " . $e->getMessage());
}

// Get recommended matches
$recommended_matches = [];
try {
    $stmt = $conn->prepare("
        SELECT u.id, u.username, cp.company_name, cp.description, cp.industry_focus 
        FROM users u
        INNER JOIN corporate_profiles cp ON u.id = cp.user_id
        WHERE u.user_type = 'corporate'
        ORDER BY RAND()
        LIMIT 3
    ");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $recommended_matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching recommended matches: " . $e->getMessage());
}

// Get recent messages
$recent_messages = [];
try {
    // This is just a placeholder - you would need an actual messages table
    /*
    $stmt = $conn->prepare("
        SELECT m.*, u.username, cp.company_name
        FROM messages m
        INNER JOIN users u ON m.sender_id = u.id
        LEFT JOIN corporate_profiles cp ON u.id = cp.user_id
        WHERE m.recipient_id = :user_id
        ORDER BY m.created_at DESC
        LIMIT 3
    ");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $recent_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    */
} catch(PDOException $e) {
    // Handle error
    error_log("Error fetching recent messages: " . $e->getMessage());
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
    $initials = "TS"; // Default
}
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
    <!-- Include Points Display Component -->
    <?php include 'points_display.php'; ?>
    
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
                <a href="startdash.php" class="text-primary transition">Dashboard</a>
                <a href="startup-matches.php" class="hover:text-primary transition">Matches</a>
                <a href="startup-messages.php" class="hover:text-primary transition">Messages</a>
                <a href="startup-profile.php" class="hover:text-primary transition">Profile</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-white hover:text-primary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
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
                <h1 class="font-['Playfair_Display'] text-3xl font-bold mb-2">Startup Dashboard</h1>
                <p class="text-gray-300">Welcome back, <?php echo htmlspecialchars($company_name); ?>! Here's your business overview.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="startup-profile.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Complete Profile</a>
            </div>
        </div>
    </section>

    <!-- Dashboard Stats -->
    <section class="container mx-auto px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Profile Completion</h3>
                    <span class="text-primary"><?php echo $profile_completion; ?>%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2.5">
                    <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo $profile_completion; ?>%"></div>
                </div>
                <p class="text-sm text-gray-400 mt-2">Complete your profile to get better matches</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">New Matches</h3>
                    <span class="bg-primary bg-opacity-20 text-primary px-2 py-1 rounded text-sm">+5 this week</span>
                </div>
                <p class="text-3xl font-bold"><?php echo $matches_count; ?></p>
                <p class="text-sm text-gray-400 mt-2">Potential corporate partners</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Active Conversations</h3>
                </div>
                <p class="text-3xl font-bold">4</p>
                <p class="text-sm text-gray-400 mt-2">Ongoing discussions</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Points Earned</h3>
                    <span class="bg-secondary bg-opacity-20 text-secondary px-2 py-1 rounded text-sm">+12 this week</span>
                </div>
                <p class="text-3xl font-bold"><?php echo $total_points; ?></p>
                <p class="text-sm text-gray-400 mt-2">Redeem for rewards</p>
            </div>
        </div>
    </section>

    <!-- Recommended Matches -->
    <section class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-['Playfair_Display'] font-bold mb-6">Recommended Matches</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php if (count($recommended_matches) > 0): 
                $bg_colors = [
                    ['from-blue-500', 'to-purple-600', 'blue-600'],
                    ['from-green-500', 'to-teal-600', 'green-600'],
                    ['from-red-500', 'to-orange-600', 'red-600']
                ];
                
                foreach ($recommended_matches as $index => $match): 
                    $colors = $bg_colors[$index % count($bg_colors)];
                    $match_initials = substr($match['company_name'] ?? $match['username'], 0, 2);
            ?>
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="h-32 bg-gradient-to-r <?php echo $colors[0].' '.$colors[1]; ?>"></div>
                <div class="p-6 relative">
                    <div class="absolute -top-8 left-6 w-16 h-16 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-<?php echo $colors[2]; ?> font-bold text-xl"><?php echo strtoupper($match_initials); ?></span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($match['company_name'] ?? $match['username']); ?></h3>
                        <p class="text-gray-400 text-sm mb-4"><?php echo htmlspecialchars(substr($match['description'], 0, 100).'...'); ?></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php 
                            $industries = explode(',', $match['industry_focus'] ?? '');
                            $tag_colors = ['blue', 'purple', 'pink', 'red', 'orange', 'yellow', 'green'];
                            foreach ($industries as $i => $industry): 
                                $tag_color = $tag_colors[$i % count($tag_colors)];
                                if (!empty(trim($industry))):
                            ?>
                            <span class="bg-<?php echo $tag_color; ?>-500 bg-opacity-20 text-<?php echo $tag_color; ?>-400 px-2 py-1 rounded text-xs"><?php echo htmlspecialchars(trim($industry)); ?></span>
                            <?php 
                                endif;
                            endforeach; 
                            
                            if (empty($industries) || count($industries) < 3): 
                            ?>
                            <span class="bg-blue-500 bg-opacity-20 text-blue-400 px-2 py-1 rounded text-xs">Enterprise</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-400">Match Score: <span class="text-primary font-semibold"><?php echo rand(75, 95); ?>%</span></span>
                            <a href="startup-matches.php?id=<?php echo $match['id']; ?>" class="text-primary hover:underline text-sm">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-span-3 bg-dark bg-opacity-50 rounded-xl p-8 text-center">
                <p class="text-gray-300 mb-4">We don't have any matches for you yet. Complete your profile to get matched with corporations.</p>
                <a href="startup-profile.php" class="inline-block bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Complete Your Profile</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-8">
            <a href="startup-matches.php" class="border border-primary text-primary hover:bg-primary hover:bg-opacity-10 px-6 py-2 rounded-full transition">View All Matches</a>
        </div>
    </section>

    <!-- Recent Messages -->
    <section class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-['Playfair_Display'] font-bold mb-6">Recent Messages</h2>
        <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
            <div class="divide-y divide-gray-800">
                <!-- Sample messages - would be populated from database -->
                <div class="p-4 hover:bg-gray-800 transition cursor-pointer">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="font-semibold text-sm">GC</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="font-semibold">Global Corp</h4>
                                <span class="text-xs text-gray-400">2 hours ago</span>
                            </div>
                            <p class="text-sm text-gray-300 mb-1">We'd like to discuss your AI solution for our customer service department...</p>
                            <a href="startup-messages.php?conversation=1" class="text-xs text-primary">View conversation</a>
                        </div>
                    </div>
                </div>
                <div class="p-4 hover:bg-gray-800 transition cursor-pointer">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mr-4">
                            <span class="font-semibold text-sm">EC</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="font-semibold">EcoSolutions</h4>
                                <span class="text-xs text-gray-400">Yesterday</span>
                            </div>
                            <p class="text-sm text-gray-300 mb-1">Thank you for sharing your proposal. Our team is reviewing it and we'll get back to you...</p>
                            <a href="startup-messages.php?conversation=2" class="text-xs text-primary">View conversation</a>
                        </div>
                    </div>
                </div>
                <div class="p-4 hover:bg-gray-800 transition cursor-pointer">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                            <span class="font-semibold text-sm">IN</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="font-semibold">InnovateCorp</h4>
                                <span class="text-xs text-gray-400">2 days ago</span>
                            </div>
                            <p class="text-sm text-gray-300 mb-1">We're interested in scheduling a demo of your product next week...</p>
                            <a href="startup-messages.php?conversation=3" class="text-xs text-primary">View conversation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-8">
            <a href="startup-messages.php" class="border border-primary text-primary hover:bg-primary hover:bg-opacity-10 px-6 py-2 rounded-full transition">View All Messages</a>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-['Playfair_Display'] font-bold mb-6">Upcoming Events</h2>
        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-gray-800 rounded-lg p-4 hover:border-primary transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="bg-primary bg-opacity-20 text-primary px-2 py-1 rounded text-xs">Virtual</span>
                            <h3 class="text-lg font-semibold mt-2">Startup-Corporate Networking Event</h3>
                        </div>
                        <div class="bg-dark rounded-lg px-3 py-2 text-center">
                            <span class="block text-sm font-semibold">MAY</span>
                            <span class="block text-xl font-bold">15</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-300 mb-4">Connect with potential corporate partners in this exclusive virtual networking event.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">10:00 AM - 12:00 PM EST</span>
                        <a href="startup-events.php?event=1&action=rsvp" class="text-primary hover:underline text-sm">RSVP</a>
                    </div>
                </div>
                <div class="border border-gray-800 rounded-lg p-4 hover:border-primary transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="bg-secondary bg-opacity-20 text-secondary px-2 py-1 rounded text-xs">In-Person</span>
                            <h3 class="text-lg font-semibold mt-2">Pitch Competition</h3>
                        </div>
                        <div class="bg-dark rounded-lg px-3 py-2 text-center">
                            <span class="block text-sm font-semibold">MAY</span>
                            <span class="block text-xl font-bold">22</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-300 mb-4">Present your startup to a panel of corporate investors and win potential funding.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">2:00 PM - 5:00 PM EST</span>
                        <a href="startup-events.php?event=2&action=apply" class="text-primary hover:underline text-sm">Apply</a>
                    </div>
                </div>
            </div>
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