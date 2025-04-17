<?php
// Start session
session_start();

// Include database connection
require_once 'backend/config/database.php';

// Initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $database = new Database();
        $conn = $database->getConnection();
        
        // Check if input is an email
        $is_email = filter_var($username, FILTER_VALIDATE_EMAIL);
        
        if ($is_email) {
            // If input is an email, search by email
            $sql = "SELECT id, username, password, user_type FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $username, PDO::PARAM_STR);
        } else {
            // Otherwise search by username
            $sql = "SELECT id, username, password, user_type FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        }
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if username exists, if yes then verify password
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $id = $row["id"];
                    $username = $row["username"];
                    $hashed_password = $row["password"];
                    $user_type = $row["user_type"];
                    
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["user_type"] = $user_type;
                        
                        // Redirect user to dashboard based on user type
                        if ($user_type == "startup") {
                            header("location: dashboard/startup.php");
                        } else {
                            header("location: dashboard/corporate.php");
                        }
                    } else {
                        // Password is not valid
                        $login_err = "Invalid username or password.";
                    }
                }
            } else {
                // Username doesn't exist
                $login_err = "Invalid username or password.";
            }
        } else {
            $login_err = "Oops! Something went wrong. Please try again later.";
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biz-Fusion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        dark: '#0A0F1D',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-['Poppins'] bg-gradient-to-t from-[#0A0F1D] to-[#000000] text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-dark bg-opacity-50 rounded-xl shadow-lg">
        <div class="text-center mb-8">
            <a href="index.php">
                <img src="public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-12 mx-auto mb-4">
            </a>
            <h2 class="text-2xl font-['Playfair_Display'] font-bold">Sign In to Biz-Fusion</h2>
            <p class="text-gray-400">Connect with partners and grow your business</p>
        </div>
        
        <?php 
        if(!empty($login_err)){
            echo '<div class="bg-red-500 bg-opacity-20 text-red-100 p-4 rounded-lg mb-6">' . $login_err . '</div>';
        }        
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Email or Username</label>
                <input type="text" name="username" id="username" class="w-full px-4 py-2 bg-dark bg-opacity-70 border border-gray-700 rounded-lg focus:outline-none focus:border-primary <?php echo (!empty($username_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $username; ?>">
                <span class="text-red-400 text-xs mt-1"><?php echo $username_err; ?></span>
            </div>    
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-dark bg-opacity-70 border border-gray-700 rounded-lg focus:outline-none focus:border-primary <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>">
                <span class="text-red-400 text-xs mt-1"><?php echo $password_err; ?></span>
            </div>
            <div class="mb-6">
                <button type="submit" class="w-full bg-primary hover:bg-opacity-90 text-white font-medium py-2 px-4 rounded-full transition">Sign In</button>
            </div>
            <div class="text-center text-gray-400 text-sm">
                <p>Don't have an account? <a href="lib/auth/startup-register.php" class="text-primary hover:underline">Register as Startup</a> or <a href="lib/auth/corporate-register.php" class="text-primary hover:underline">Register as Corporate</a></p>
            </div>
        </form>
    </div>
</body>
</html> 