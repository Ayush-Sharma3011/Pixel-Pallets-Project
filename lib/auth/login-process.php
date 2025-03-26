<?php
session_start();
require_once 'config.php';
require_once 'points_system.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from form
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both email and password.";
        header("Location: login.html");
        exit();
    }
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password, user_type, total_points FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            session_regenerate_id();
            
            // Store user data in session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['total_points'] = $user['total_points'];
            
            // Update last login time
            $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param("i", $user['id']);
            $updateStmt->execute();
            
            // Award points for daily login
            $pointsSystem = new PointsSystem($conn);
            $pointsAwarded = $pointsSystem->awardLoginPoints($user['id']);
            
            if ($pointsAwarded) {
                $_SESSION['points_message'] = "You earned " . POINTS_LOGIN . " points for logging in today!";
                // Update session points
                $_SESSION['total_points'] += POINTS_LOGIN;
            }
            
            // Redirect based on user type
            if ($user['user_type'] == 'startup') {
                header("Location: startup-dashboard.html");
            } else {
                header("Location: corporate-dashboard.html");
            }
            exit();
        } else {
            // Password is incorrect
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: login.html");
            exit();
        }
    } else {
        // User doesn't exist
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: login.html");
        exit();
    }
} else {
    // Not a POST request, redirect to login page
    header("Location: login.html");
    exit();
}
?> 