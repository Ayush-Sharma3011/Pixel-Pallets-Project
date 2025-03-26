<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'bizfusion';

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Points configuration
define('POINTS_LOGIN', 5);                  // Points for daily login
define('POINTS_REGISTER_STARTUP', 50);      // Points for registering as startup
define('POINTS_REGISTER_CORPORATE', 50);    // Points for registering as corporate
define('POINTS_COMPLETE_PROFILE', 25);      // Points for completing profile
define('POINTS_CONNECT_MATCH', 15);         // Points for connecting with a match
define('POINTS_POST_INNOVATION_NEED', 20);  // Points for posting innovation need (corporate)
define('POINTS_SUBMIT_SOLUTION', 20);       // Points for submitting solution (startup)
define('POINTS_SUCCESSFUL_PARTNERSHIP', 100); // Points for successful partnership
?> 