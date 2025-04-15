<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Contact.php';

$session = new Session();
$session->requireLogin();
$session->requireAdmin(); // Only admins can access this page

$user = new User();
$contact = new Contact();

// Get all contact messages
$contact_results = $contact->readAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo SITE_NAME; ?></title>
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
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Admin Panel</h1>
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
                <h2>Contact Messages</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $contact_results->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                <td><?php echo htmlspecialchars($row['message']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
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