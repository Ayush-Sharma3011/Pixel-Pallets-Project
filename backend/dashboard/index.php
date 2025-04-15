<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../models/User.php';

$session = new Session();
$session->requireLogin();

$user = new User();
$user->getUserById($session->get('user_id'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($user->username); ?>!</h1>
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
            <div class="dashboard-widgets">
                <div class="widget">
                    <h3>Your Profile</h3>
                    <p>Email: <?php echo htmlspecialchars($user->email); ?></p>
                    <p>Role: <?php echo htmlspecialchars($user->role); ?></p>
                    <a href="<?php echo SITE_URL; ?>/backend/dashboard/profile.php" class="btn btn-primary">Edit Profile</a>
                </div>

                <?php if ($session->isAdmin()): ?>
                <div class="widget">
                    <h3>Admin Tools</h3>
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/users.php">Manage Users</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/messages.php">View Messages</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/settings.php">Site Settings</a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </main>

        <footer class="dashboard-footer">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </footer>
    </div>
</body>
</html> 