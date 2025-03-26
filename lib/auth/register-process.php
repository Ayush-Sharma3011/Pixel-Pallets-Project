<?php
session_start();
require_once 'config.php';
require_once 'points_system.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_type = $_POST['user_type'] ?? ''; // 'startup' or 'corporate'
    
    // Basic validation
    $errors = [];
    
    if (empty($first_name) || empty($last_name)) {
        $errors[] = "Please enter your full name.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    
    if (empty($user_type) || !in_array($user_type, ['startup', 'corporate'])) {
        $errors[] = "Please select a valid user type.";
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errors[] = "Email already exists. Please use a different email or login.";
    }
    
    // If there are errors, redirect back to registration page
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        $_SESSION['form_data'] = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'user_type' => $user_type
        ];
        
        if ($user_type == 'startup') {
            header("Location: startup-register.html");
        } else {
            header("Location: corporate-register.html");
        }
        exit();
    }
    
    // No errors, proceed with registration
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Create username from first name and last name
    $username = strtolower($first_name . '.' . $last_name);
    
    // Check if username exists, if so, add a number
    $base_username = $username;
    $i = 1;
    
    do {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $username = $base_username . $i;
            $i++;
        } else {
            break;
        }
    } while (true);
    
    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);
    
    if ($stmt->execute()) {
        // Get the new user ID
        $user_id = $conn->insert_id;
        
        // Award points for registration
        $pointsSystem = new PointsSystem($conn);
        $pointsSystem->awardRegistrationPoints($user_id, $user_type);
        
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['total_points'] = ($user_type == 'startup') ? POINTS_REGISTER_STARTUP : POINTS_REGISTER_CORPORATE;
        $_SESSION['points_message'] = "Welcome! You earned " . $_SESSION['total_points'] . " points for registering!";
        
        // Redirect to the appropriate dashboard
        if ($user_type == 'startup') {
            header("Location: startup-dashboard.html");
        } else {
            header("Location: corporate-dashboard.html");
        }
        exit();
    } else {
        $_SESSION['register_errors'] = ["Registration failed. Please try again."];
        
        if ($user_type == 'startup') {
            header("Location: startup-register.html");
        } else {
            header("Location: corporate-register.html");
        }
        exit();
    }
} else {
    // Not a POST request, redirect to home page
    header("Location: index.html");
    exit();
}
?> 