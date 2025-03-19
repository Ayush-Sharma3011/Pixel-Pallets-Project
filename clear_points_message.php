<?php
session_start();

// Clear the points message from session
if (isset($_SESSION['points_message'])) {
    unset($_SESSION['points_message']);
}

// Return a success response
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?> 