<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../includes/Session.php';

$session = new Session();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        $session->set('user_id', $user->id);
        $session->set('user_username', $user->username);
        $session->set('user_role', $user->role);
        $session->setFlash('Login successful!', 'success');
        header("Location: " . SITE_URL . "/backend/dashboard/index.php");
        exit();
    } else {
        $session->setFlash('Invalid email or password', 'error');
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
    <title>Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php
        $flash = $session->getFlash();
        if ($flash) {
            echo '<div class="alert alert-' . $flash['type'] . '">' . $flash['message'] . '</div>';
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Don't have an account? <a href="<?php echo SITE_URL; ?>/backend/auth/register.php">Register here</a></p>
        <p><a href="<?php echo SITE_URL; ?>/index.html">Back to Home</a></p>
    </div>
</body>
</html> 