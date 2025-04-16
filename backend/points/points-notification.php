<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Function to get points notification if available
 * 
 * @return array|null Notification data or null if no notification
 */
function getPointsNotification() {
    if (isset($_SESSION['points_message']) && isset($_SESSION['points_amount'])) {
        return [
            'message' => $_SESSION['points_message'],
            'amount' => $_SESSION['points_amount']
        ];
    }
    return null;
}

/**
 * Function to render points notification HTML
 * 
 * @return string HTML for points notification or empty string if no notification
 */
function renderPointsNotification() {
    $notification = getPointsNotification();
    
    if (!$notification) {
        return '';
    }
    
    $message = htmlspecialchars($notification['message']);
    $amount = htmlspecialchars($notification['amount']);
    
    // HTML for notification
    return <<<HTML
    <div class="points-notification" id="points-notification">
        <div class="points-notification-content">
            <div class="points-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="points-message">
                {$message}
            </div>
            <div class="points-amount">
                +{$amount} points
            </div>
        </div>
        <button class="points-close" onclick="clearPointsNotification()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
    function clearPointsNotification() {
        document.getElementById('points-notification').style.display = 'none';
        
        // Call the clear points message endpoint
        fetch('backend/points/clear_points_message.php', {
            method: 'POST'
        }).then(response => response.json())
          .catch(error => console.error('Error clearing points notification:', error));
    }
    
    // Auto-hide the notification after 5 seconds
    setTimeout(function() {
        const notification = document.getElementById('points-notification');
        if (notification) {
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.style.display = 'none';
                clearPointsNotification();
            }, 1000);
        }
    }, 5000);
    </script>
HTML;
}

// If this file is accessed directly, return notification as JSON
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('Content-Type: application/json');
    echo json_encode(['notification' => getPointsNotification()]);
    exit;
}
?> 