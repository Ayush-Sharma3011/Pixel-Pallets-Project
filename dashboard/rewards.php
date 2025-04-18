<?php
// Start session
    session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit();
}

// Redirect to the new rewards center
header("Location: ../lib/rewards/index.php");
exit();
?> 