<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

// Include required files
require_once '../backend/config/config.php';
require_once '../backend/config/database.php';
require_once '../backend/config/points_config.php';
require_once '../backend/models/Points.php';
require_once '../backend/models/User.php';

// Get user information
$user = new User();
$user->getUserById($_SESSION['user_id']);
$user_type = $user->user_type;

// Get points information
$points = new Points();
$user_id = $_SESSION['user_id'];
$total_points = $points->getUserPoints($user_id);
$level_info = $points->getUserLevel($user_id);
$points_history = $points->getPointsHistory($user_id, 20);

// Get leaderboard
$leaderboard = $points->getLeaderboard(5, $user_type);

// Calculate progress percentage to next level
$progress_percentage = 0;
if ($level_info['current_level'] < 5) {
    $current_level_points = $POINTS_LEVELS[$level_info['current_level']];
    $next_level_points = $POINTS_LEVELS[$level_info['next_level']];
    $points_range = $next_level_points - $current_level_points;
    $user_progress = $total_points - $current_level_points;
    $progress_percentage = ($user_progress / $points_range) * 100;
}

// Function to get level badge background color
function getLevelBadgeColor($level) {
    switch ($level) {
        case 1: return 'bg-yellow-700'; // Bronze
        case 2: return 'bg-gray-400';   // Silver
        case 3: return 'bg-yellow-400'; // Gold
        case 4: return 'bg-blue-500';   // Platinum
        case 5: return 'bg-purple-500'; // Diamond
        default: return 'bg-gray-600';
    }
}
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
                <a href="../index.html">
                    <img src="../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="<?php echo strtolower($user_type); ?>.html" class="hover:text-primary transition">Dashboard</a>
                <a href="#" class="hover:text-primary transition">Matches</a>
                <a href="#" class="hover:text-primary transition">Messages</a>
                <a href="#" class="hover:text-primary transition">Profile</a>
                <a href="rewards.php" class="text-primary transition">Rewards</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <span class="font-semibold text-sm"><?php echo strtoupper(substr($user->username, 0, 2)); ?></span>
                    </div>
                    <span><?php echo $user->username; ?></span>
                </div>
                <a href="../index.html" class="text-sm text-gray-400 hover:text-white">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="font-['Playfair_Display'] text-3xl font-bold mb-2">Rewards Center</h1>
                <p class="text-gray-300">Track your progress, earn points, and unlock rewards!</p>
            </div>
        </div>
    </section>

    <!-- Points Summary -->
    <section class="container mx-auto px-6 py-4">
        <div class="bg-dark bg-opacity-50 rounded-xl p-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <!-- Level Badge -->
                <div class="flex flex-col items-center mb-6 md:mb-0">
                    <div class="<?php echo getLevelBadgeColor($level_info['current_level']); ?> rounded-full w-24 h-24 flex items-center justify-center mb-4">
                        <span class="text-white font-bold text-4xl"><?php echo $level_info['current_level']; ?></span>
                    </div>
                    <h3 class="text-xl font-semibold"><?php echo $level_info['level_name']; ?> Level</h3>
                </div>
                
                <!-- Points & Progress -->
                <div class="flex-1 md:px-10 flex flex-col items-center md:items-start">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-yellow-400 font-bold text-3xl"><?php echo number_format($total_points); ?></span>
                        <span class="text-gray-300 ml-2">total points</span>
                    </div>
                    
                    <?php if ($level_info['current_level'] < 5): ?>
                    <div class="w-full mb-2">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-300">Progress to <?php echo $level_info['next_level_name']; ?></span>
                            <span class="text-sm text-gray-300"><?php echo number_format($level_info['points_needed']); ?> points needed</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                            <div class="<?php echo getLevelBadgeColor($level_info['next_level']); ?> h-2.5 rounded-full" style="width: <?php echo $progress_percentage; ?>%"></div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="w-full mb-2">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-300">Maximum Level Reached</span>
                            <span class="text-sm text-gray-300">Congratulations!</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                            <div class="bg-purple-500 h-2.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Next Level Benefits -->
                <div class="bg-gray-900 bg-opacity-50 rounded-lg p-6 md:w-1/3">
                    <?php if ($level_info['current_level'] < 5): ?>
                    <h4 class="text-lg font-semibold mb-3">Next Level Benefits</h4>
                    <ul class="space-y-2">
                        <?php foreach ($LEVEL_BENEFITS[$level_info['next_level']] as $benefit): ?>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300"><?php echo $benefit; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <h4 class="text-lg font-semibold mb-3">Diamond Benefits</h4>
                    <ul class="space-y-2">
                        <?php foreach ($LEVEL_BENEFITS[5] as $benefit): ?>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300"><?php echo $benefit; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content: History and Leaderboard -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Points History -->
            <div class="lg:w-2/3">
                <h2 class="text-2xl font-['Playfair_Display'] font-bold mb-6">Points History</h2>
                <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Activity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Points</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            <?php if (empty($points_history)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">No points history yet. Start earning points!</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($points_history as $record): ?>
                                <tr class="hover:bg-gray-800 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-white"><?php echo htmlspecialchars($record['activity']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-primary font-semibold">+<?php echo number_format($record['points']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-300"><?php echo date('M j, Y g:i A', strtotime($record['date_earned'])); ?></div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Leaderboard -->
            <div class="lg:w-1/3">
                <h2 class="text-2xl font-['Playfair_Display'] font-bold mb-6">Top <?php echo ucfirst($user_type); ?>s</h2>
                <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                    <div class="p-6">
                        <?php foreach ($leaderboard as $index => $leader): ?>
                        <div class="flex items-center justify-between py-3 <?php echo $index < count($leaderboard) - 1 ? 'border-b border-gray-800' : ''; ?>">
                            <div class="flex items-center">
                                <div class="<?php echo $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : ($index === 2 ? 'bg-yellow-700' : 'bg-gray-700')); ?> w-8 h-8 rounded-full flex items-center justify-center mr-4">
                                    <span class="font-bold text-sm"><?php echo $index + 1; ?></span>
                                </div>
                                <div>
                                    <p class="font-medium"><?php echo htmlspecialchars($leader['company_name'] ?: $leader['username']); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo ucfirst($leader['user_type']); ?></p>
                                </div>
                            </div>
                            <div class="text-yellow-400 font-semibold"><?php echo number_format($leader['total_points']); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- How to Earn Points -->
                <h2 class="text-2xl font-['Playfair_Display'] font-bold mt-8 mb-6">How to Earn Points</h2>
                <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                    <div class="p-6">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Daily Login</p>
                                    <p class="text-sm text-gray-400">+<?php echo POINTS_LOGIN; ?> points (once per day)</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Complete Profile</p>
                                    <p class="text-sm text-gray-400">+<?php echo POINTS_COMPLETE_PROFILE; ?> points</p>
                                </div>
                            </li>
                            <?php if ($user_type == 'startup'): ?>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Submit Solution</p>
                                    <p class="text-sm text-gray-400">+<?php echo POINTS_SUBMIT_SOLUTION; ?> points per solution</p>
                                </div>
                            </li>
                            <?php else: ?>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Post Innovation Need</p>
                                    <p class="text-sm text-gray-400">+<?php echo POINTS_POST_INNOVATION_NEED; ?> points per need</p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Connect with Match</p>
                                    <p class="text-sm text-gray-400">+<?php echo POINTS_CONNECT_MATCH; ?> points per connection</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-20 p-2 rounded-full flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Form Partnership</p>
                                    <p class="text-sm text-gray-400">+<?php echo POINTS_SUCCESSFUL_PARTNERSHIP; ?> points per partnership</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-8 mt-16">
        <div class="container mx-auto px-6">
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; 2023 Biz-Fusion. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 