<?php
/**
 * Points Display Component
 * 
 * Include this file in dashboard pages to display points notifications
 * and the current points balance.
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    return;
}

$total_points = $_SESSION['total_points'] ?? 0;
$points_message = $_SESSION['points_message'] ?? null;

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
?>

<!-- Points Display -->
<div class="fixed top-20 right-6 z-50 flex flex-col items-end space-y-4">
    <!-- Points Balance -->
    <div class="bg-dark bg-opacity-90 border border-gray-700 rounded-full px-4 py-2 flex items-center shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-yellow-400 font-semibold"><?php echo $total_points; ?></span>
        <span class="text-gray-300 ml-1">points</span>
    </div>
    
    <!-- Points Notification -->
    <?php if ($points_message): ?>
    <div id="points-notification" class="bg-dark bg-opacity-90 border border-primary rounded-lg px-4 py-3 shadow-lg max-w-xs transform transition-all duration-500 translate-x-0">
        <div class="flex items-start">
            <div class="flex-shrink-0 text-primary">
                <?php echo getPointsIcon($points_message); ?>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-white"><?php echo $points_message; ?></p>
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
            fetch('clear_points_message.php');
        }
    </script>
    <?php endif; ?>
</div>

<!-- View All Points Link -->
<div class="fixed bottom-6 right-6 z-50">
    <a href="rewards.php" class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-full shadow-lg flex items-center transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Rewards Center
    </a>
</div> 