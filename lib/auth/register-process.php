<?php
session_start();

// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Include points system if needed
// require_once '../points/PointsSystem.php';

// Process registration if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $company_name = trim($_POST["company_name"]);
    $user_type = trim($_POST["user_type"]);
    $job_title = isset($_POST["job_title"]) ? trim($_POST["job_title"]) : '';
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';
    
    // Validate input
    $errors = [];
    
    // Validate first name
    if (empty($first_name)) {
        $errors[] = "Please enter your first name.";
    }
    
    // Validate last name
    if (empty($last_name)) {
        $errors[] = "Please enter your last name.";
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    // Validate password
    if (empty($password)) {
        $errors[] = "Please enter a password.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    
    // Validate confirm password
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    
    // Validate company name
    if (empty($company_name)) {
        $errors[] = "Please enter your company name.";
    }
    
    // Validate user type
    if (empty($user_type) || ($user_type != "startup" && $user_type != "corporate")) {
        $errors[] = "Invalid user type.";
    }
    
    // If there are any errors, redirect back to the registration form
    if (count($errors) > 0) {
        $_SESSION["register_errors"] = $errors;
        if ($user_type == "startup") {
            header("Location: startup-register.php");
        } else {
            header("Location: corporate-register.php");
        }
        exit();
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $_SESSION["register_errors"] = ["Email already exists. Please use a different email or login."];
        if ($user_type == "startup") {
            header("Location: startup-register.php");
        } else {
            header("Location: corporate-register.php");
        }
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Create username from first name, last name and random number
    $username = strtolower($first_name . "." . $last_name . rand(100, 999));
    
    // Insert user into database
    try {
        // Begin transaction
        $conn->beginTransaction();
        
        // Enable PDO error mode
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Debug mode - capture errors in a more detailed way
        error_log("Starting user registration for: $email ($user_type)");
        
        // Insert into users table
        $sql = "INSERT INTO users (username, email, password, role, user_type, company_name, created_at) 
                VALUES (:username, :email, :password, 'user', :user_type, :company_name, NOW())";
        
        error_log("SQL Query: $sql");
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(":user_type", $user_type, PDO::PARAM_STR);
        $stmt->bindParam(":company_name", $company_name, PDO::PARAM_STR);
        
        // Detailed logging
        error_log("Parameters: username=$username, email=$email, user_type=$user_type, company_name=$company_name");
        
        $result = $stmt->execute();
        error_log("Query executed with result: " . ($result ? "success" : "failure"));
        
        // Get the user ID
        $user_id = $conn->lastInsertId();
        error_log("New user ID: $user_id");
        
        // Create profile entry based on user type
        if ($user_type == "startup") {
            $stmt = $conn->prepare("INSERT INTO startup_profiles (user_id) VALUES (:user_id)");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            error_log("Created startup profile for user ID: $user_id");
        } else if ($user_type == "corporate") {
            $stmt = $conn->prepare("INSERT INTO corporate_profiles (user_id) VALUES (:user_id)");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            error_log("Created corporate profile for user ID: $user_id");
        }
        
        // Award registration points (to be implemented)
        // $pointsSystem = new PointsSystem($conn);
        // $pointsAwarded = $pointsSystem->awardRegistrationPoints($user_id, $user_type);
        
        // Commit transaction
        $conn->commit();
        error_log("Transaction committed successfully");
        
        // Set session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $user_id;
        $_SESSION["username"] = $username;
        $_SESSION["user_type"] = $user_type;
        error_log("Session variables set: id=$user_id, username=$username, user_type=$user_type");
        
        // Redirect to dashboard
        if ($user_type == "startup") {
            header("Location: ../../dashboard/startup.php");
        } else {
            header("Location: ../../dashboard/corporate.php");
        }
        exit();
        
    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();
        
        // Log the detailed error message
        error_log("Registration failed: " . $e->getMessage());
        
        // Check if the database exists
        try {
            $checkDb = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'bizfusion'");
            if ($checkDb->rowCount() == 0) {
                error_log("Database 'bizfusion' does not exist!");
                $_SESSION["register_errors"] = ["The database does not exist. Please run the setup script first."];
            } else {
                // Check if the users table exists
                $checkTable = $conn->query("SHOW TABLES LIKE 'users'");
                if ($checkTable->rowCount() == 0) {
                    error_log("Table 'users' does not exist!");
                    $_SESSION["register_errors"] = ["The database tables are not set up correctly. Please run the setup script."];
                } else {
                    // Regular error message
                    $_SESSION["register_errors"] = ["Registration failed: " . $e->getMessage()];
                }
            }
        } catch (Exception $e2) {
            error_log("Error checking database structure: " . $e2->getMessage());
            $_SESSION["register_errors"] = ["Registration failed due to a database error. Please contact the administrator."];
        }
        
        if ($user_type == "startup") {
            header("Location: startup-register.php");
        } else {
            header("Location: corporate-register.php");
        }
        exit();
    }
    
} else {
    // Not a POST request, redirect to home page
    header("Location: ../../index.php");
    exit();
}
?> 