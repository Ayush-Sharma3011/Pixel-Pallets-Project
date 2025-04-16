<?php
session_start();
include_once 'config/database.php';
include_once 'models/User.php';
include_once 'models/Points.php';
include_once 'config/points_config.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize user object
$user = new User($db);
$points = new Points($db);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user type from form
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
    
    if (empty($user_type) || ($user_type != 'startup' && $user_type != 'corporate')) {
        $_SESSION['error'] = "Invalid user type specified";
        header("Location: ../login.html");
        exit();
    }
    
    // Get form data
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
    $industry = isset($_POST['industry']) ? $_POST['industry'] : '';
    
    // Validate input
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    if (empty($company_name)) {
        $errors[] = "Company name is required";
    }
    
    if (empty($industry)) {
        $errors[] = "Industry is required";
    }
    
    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(":email", $email);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        $errors[] = "Email already exists";
    }
    
    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        if ($user_type == 'startup') {
            header("Location: ../startup-register.html");
        } else {
            header("Location: ../corporate-register.html");
        }
        exit();
    }
    
    // Set user properties
    $user->username = $username;
    $user->email = $email;
    $user->password = $password;
    $user->user_type = $user_type;
    $user->company_name = $company_name;
    $user->industry = $industry;
    
    // Create the user
    if ($user->register()) {
        // Log the user in
        if ($user->login()) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            $_SESSION['role'] = $user->role;
            $_SESSION['user_type'] = $user->user_type;
            
            // Award registration points
            if ($user_type == 'startup') {
                $points->awardPoints($user->id, POINTS_REGISTER_STARTUP, "Registration bonus - Startup");
            } else {
                $points->awardPoints($user->id, POINTS_REGISTER_CORPORATE, "Registration bonus - Corporate");
            }
            
            $_SESSION['points_message'] = "Registration bonus";
            $_SESSION['points_amount'] = ($user_type == 'startup') ? POINTS_REGISTER_STARTUP : POINTS_REGISTER_CORPORATE;
            
            // Redirect to appropriate dashboard
            if ($user_type == 'startup') {
                header("Location: ../dashboard/startup.html");
            } else {
                header("Location: ../dashboard/corporate.html");
            }
            exit();
        } else {
            $_SESSION['error'] = "User created but login failed";
            header("Location: ../login.html");
            exit();
        }
    } else {
        $_SESSION['error'] = "Failed to create account";
        if ($user_type == 'startup') {
            header("Location: ../startup-register.html");
        } else {
            header("Location: ../corporate-register.html");
        }
        exit();
    }
} else {
    // Not a POST request, redirect to home
    header("Location: ../index.html");
    exit();
}
?> 