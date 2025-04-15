<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../models/User.php';

$session = new Session();
$session->requireLogin();

$user = new User();
$user->getUserById($session->get('user_id'));

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Simple validation
    $errors = [];
    
    // Check if current password is correct
    if (password_verify($current_password, $user->password)) {
        // Check if new passwords match
        if ($new_password === $confirm_password) {
            // Update password
            $user->password = $new_password;
            if ($user->updatePassword()) {
                $session->setFlash('Password updated successfully!', 'success');
            } else {
                $errors[] = "Failed to update password. Please try again.";
            }
        } else {
            $errors[] = "New passwords do not match.";
        }
    } else {
        $errors[] = "Current password is incorrect.";
    }
    
    if (!empty($errors)) {
        $session->setFlash(implode("<br>", $errors), 'error');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>My Profile</h1>
            <nav>
                <ul>
                    <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/index.php">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/profile.php">Profile</a></li>
                    <?php if ($session->isAdmin()): ?>
                    <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/admin.php">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo SITE_URL; ?>/backend/auth/logout.php">Logout</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/index.html">Back to Website</a></li>
                </ul>
            </nav>
        </header>

        <main class="dashboard-content">
            <div class="widget">
                <h3>Your Profile Information</h3>
                <?php
                $flash = $session->getFlash();
                if ($flash) {
                    echo '<div class="alert alert-' . $flash['type'] . '">' . $flash['message'] . '</div>';
                }
                ?>
                <div class="profile-info">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user->username); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user->role); ?></p>
                </div>
                
                <h3>Change Password</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </main>

        <footer class="dashboard-footer">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </footer>
    </div>
</body>
</html> 