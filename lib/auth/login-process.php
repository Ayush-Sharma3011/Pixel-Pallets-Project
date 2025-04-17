<?php
session_start();

// Include database connection
require_once '../../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Process login if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if email and password are set
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $_SESSION["login_error"] = "Please enter both email and password.";
        header("Location: ../../login.php");
        exit();
    }
    
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    // Prepare a select statement
    $sql = "SELECT id, username, email, password, role, user_type FROM users WHERE email = :email";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if email exists
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $row["id"];
                $username = $row["username"];
                $email = $row["email"];
                $hashed_password = $row["password"];
                $role = $row["role"];
                $user_type = $row["user_type"];
                
                // Verify password
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = $role;
                    $_SESSION["user_type"] = $user_type;
                    
                    // Record login points
                    // TODO: Implement this with points system
                    
                    // Redirect user to dashboard based on user type
                    if ($user_type == "startup") {
                        header("Location: ../../dashboard/startup.php");
                    } else {
                        header("Location: ../../dashboard/corporate.php");
                    }
                } else {
                    // Password is not valid
                    $_SESSION["login_error"] = "Invalid email or password.";
                    header("Location: ../../login.php");
                }
            } else {
                // Email doesn't exist
                $_SESSION["login_error"] = "Invalid email or password.";
                header("Location: ../../login.php");
            }
        } else {
            $_SESSION["login_error"] = "Oops! Something went wrong. Please try again later.";
            header("Location: ../../login.php");
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($conn);
} else {
    // Not a POST request, redirect to login page
    header("Location: ../../login.php");
    exit();
}
?> 