<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear points notification message
if (isset($_SESSION['points_message'])) {
    unset($_SESSION['points_message']);
}

// Clear points amount
if (isset($_SESSION['points_amount'])) {
    unset($_SESSION['points_amount']);
}

// Return success status
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?> 