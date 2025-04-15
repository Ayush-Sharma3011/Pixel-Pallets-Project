<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../includes/Session.php';

$session = new Session();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    $errors = [];
    if (empty($user->username)) {
        $errors[] = "Username is required";
    }
    if (empty($user->email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($user->password)) {
        $errors[] = "Password is required";
    }
    if ($user->password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    if ($user->emailExists()) {
        $errors[] = "Email already exists";
    }

    if (empty($errors)) {
        if ($user->register()) {
            $session->setFlash('Registration successful! Please login.', 'success');
            header("Location: " . SITE_URL . "/backend/auth/login.php");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }

    if (!empty($errors)) {
        $session->setFlash(implode("<br>", $errors), 'error');
    }
}

// If already logged in, redirect to dashboard
if ($session->isLoggedIn()) {
    header("Location: " . SITE_URL . "/backend/dashboard/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php
        $flash = $session->getFlash();
        if ($flash) {
            echo '<div class="alert alert-' . $flash['type'] . '">' . $flash['message'] . '</div>';
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p>Already have an account? <a href="<?php echo SITE_URL; ?>/backend/auth/login.php">Login here</a></p>
        <p><a href="<?php echo SITE_URL; ?>/index.html">Back to Home</a></p>
    </div>
</body>
</html> 