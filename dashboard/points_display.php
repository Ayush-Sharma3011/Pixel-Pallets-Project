<?php
/**
 * Points Display Component
 * 
 * Include this file in dashboard pages to display points notifications,
 * the current points balance, and level information.
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    return;
}

// Include required files
require_once '../backend/config/config.php';
require_once '../backend/config/database.php';
require_once '../backend/config/points_config.php';
require_once '../backend/models/Points.php';

// Get user points information
$points = new Points();
$user_id = $_SESSION['user_id'];
$total_points = $points->getUserPoints($user_id);
$level_info = $points->getUserLevel($user_id);

// Check for points notification
$points_message = $_SESSION['points_message'] ?? null;
$points_amount = $_SESSION['points_amount'] ?? null;

// Function to get points icon based on message content
function getPointsIcon($message) {
    if (strpos($message, 'login') !== false) {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>';
    } elseif (strpos($message, 'register') !== false) {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>';
    } elseif (strpos($message, 'profile') !== false) {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>';
    } elseif (strpos($message, 'connect') !== false || strpos($message, 'match') !== false) {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>';
    } else {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>';
    }
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

<!-- Points and Level Display -->
<div class="fixed top-20 right-6 z-50 flex flex-col items-end space-y-4">
    <!-- Points Balance -->
    <div class="bg-dark bg-opacity-90 border border-gray-700 rounded-xl px-5 py-3 flex items-center shadow-lg">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-yellow-400 font-bold text-xl"><?php echo number_format($total_points); ?></span>
            <span class="text-gray-300 ml-1">points</span>
        </div>
        <!-- Level Badge -->
        <div class="ml-4 pl-4 border-l border-gray-600 flex items-center">
            <div class="<?php echo getLevelBadgeColor($level_info['current_level']); ?> rounded-full w-8 h-8 flex items-center justify-center mr-2">
                <span class="text-white font-bold text-xs"><?php echo $level_info['current_level']; ?></span>
            </div>
            <div class="flex flex-col">
                <span class="text-white text-sm font-semibold"><?php echo $level_info['level_name']; ?></span>
                <?php if ($level_info['current_level'] < 5): ?>
                <span class="text-gray-400 text-xs"><?php echo number_format($level_info['points_needed']); ?> to next level</span>
                <?php else: ?>
                <span class="text-gray-400 text-xs">Max level reached</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Points Notification -->
    <?php if ($points_message && $points_amount): ?>
    <div id="points-notification" class="bg-dark bg-opacity-90 border border-primary rounded-lg px-4 py-3 shadow-lg max-w-xs transform transition-all duration-500 translate-x-0">
        <div class="flex items-start">
            <div class="flex-shrink-0 text-primary">
                <?php echo getPointsIcon($points_message); ?>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-white"><?php echo $points_message; ?></p>
                <p class="text-xs text-primary font-semibold mt-1">+<?php echo $points_amount; ?> points</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button onclick="closePointsNotification()" class="inline-flex text-gray-400 hover:text-gray-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-hide notification after 5 seconds
        setTimeout(function() {
            closePointsNotification();
        }, 5000);
        
        function closePointsNotification() {
            const notification = document.getElementById('points-notification');
            notification.classList.remove('translate-x-0');
            notification.classList.add('translate-x-full');
            
            // Remove from DOM after animation completes
            setTimeout(function() {
                notification.remove();
            }, 500);
            
            // Clear the session message
            fetch('../backend/points/clear_points_message.php');
        }
    </script>
    <?php endif; ?>
</div>

<!-- Rewards Center Button -->
<div class="fixed bottom-6 right-6 z-50">
    <a href="rewards.php" class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-full shadow-lg flex items-center transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Rewards Center
    </a>
</div> 