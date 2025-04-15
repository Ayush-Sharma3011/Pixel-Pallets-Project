<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../models/User.php';

$session = new Session();
$session->requireLogin();
$session->requireAdmin(); // Only admins can access this page

$user = new User();
$all_users = $user->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <style>
        .admin-panel {
            padding: 20px;
        }
        .admin-section {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Manage Users</h1>
            <nav>
                <ul>
                    <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/index.php">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/profile.php">Profile</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/backend/dashboard/admin.php">Admin Panel</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/backend/auth/logout.php">Logout</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/index.html">Back to Website</a></li>
                </ul>
            </nav>
        </header>

        <main class="dashboard-content admin-panel">
            <?php
            $flash = $session->getFlash();
            if ($flash) {
                echo '<div class="alert alert-' . $flash['type'] . '">' . $flash['message'] . '</div>';
            }
            ?>
            
            <div class="admin-section">
                <h2>User Management</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $all_users->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td class="action-buttons">
                                    <?php if ($row['id'] != $session->get('user_id')): ?>
                                    <a href="<?php echo SITE_URL; ?>/backend/dashboard/edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <footer class="dashboard-footer">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </footer>
    </div>
</body>
</html> 