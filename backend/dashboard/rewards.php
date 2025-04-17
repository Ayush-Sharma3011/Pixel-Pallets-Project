<?php
// Start session
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== "admin") {
    header("location: ../login.php");
    exit;
}

// Include database connection
require_once '../config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Include rewards system class
require_once '../../lib/rewards/RewardsSystem.php';
$rewardsSystem = new RewardsSystem($conn);

// Handle actions
$message = '';
$messageType = '';

// Handle reward deletion
if (isset($_GET['delete_reward']) && !empty($_GET['delete_reward'])) {
    $reward_id = $_GET['delete_reward'];
    
    try {
        $stmt = $conn->prepare("DELETE FROM rewards WHERE id = :id");
        $stmt->bindParam(':id', $reward_id);
        
        if ($stmt->execute()) {
            $message = "Reward deleted successfully.";
            $messageType = "success";
        } else {
            $message = "Error deleting reward.";
            $messageType = "danger";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $messageType = "danger";
    }
}

// Handle reward status toggle
if (isset($_GET['toggle_status']) && !empty($_GET['toggle_status'])) {
    $reward_id = $_GET['toggle_status'];
    
    try {
        $stmt = $conn->prepare("UPDATE rewards SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
        $stmt->bindParam(':id', $reward_id);
        
        if ($stmt->execute()) {
            $message = "Reward status updated successfully.";
            $messageType = "success";
        } else {
            $message = "Error updating reward status.";
            $messageType = "danger";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $messageType = "danger";
    }
}

// Handle redemption status update
if (isset($_GET['complete_redemption']) && !empty($_GET['complete_redemption'])) {
    $redemption_id = $_GET['complete_redemption'];
    
    try {
        $stmt = $conn->prepare("UPDATE reward_redemptions SET status = 'completed', completion_date = NOW() WHERE id = :id AND status = 'pending'");
        $stmt->bindParam(':id', $redemption_id);
        
        if ($stmt->execute()) {
            $message = "Redemption marked as completed.";
            $messageType = "success";
        } else {
            $message = "Error updating redemption status.";
            $messageType = "danger";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $messageType = "danger";
    }
}

// Get rewards with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $conn->prepare("SELECT * FROM rewards ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rewards = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT COUNT(*) FROM rewards");
$stmt->execute();
$totalRewards = $stmt->fetchColumn();
$totalPages = ceil($totalRewards / $limit);

// Get recent redemptions
$stmt = $conn->prepare("
    SELECT r.*, rw.title, u.username, u.user_type 
    FROM reward_redemptions r
    JOIN rewards rw ON r.reward_id = rw.id
    JOIN users u ON r.user_id = u.id
    ORDER BY r.redemption_date DESC
    LIMIT 15
");
$stmt->execute();
$redemptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rewards - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
<body class="bg-gray-100 font-['Poppins']">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-dark">
                <div class="flex items-center h-16 px-4 bg-dark border-b border-gray-800">
                    <span class="text-lg font-semibold text-white">Admin Dashboard</span>
                </div>
                <div class="flex flex-col flex-grow p-4">
                    <nav class="flex-1 space-y-2">
                        <a href="index.php" class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="users.php" class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800">
                            <i class="fas fa-users mr-3"></i>
                            <span>Users</span>
                        </a>
                        <a href="rewards.php" class="flex items-center px-4 py-2 text-white bg-primary rounded-lg">
                            <i class="fas fa-gift mr-3"></i>
                            <span>Rewards</span>
                        </a>
                        <a href="partnerships.php" class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800">
                            <i class="fas fa-handshake mr-3"></i>
                            <span>Partnerships</span>
                        </a>
                        <a href="reports.php" class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800">
                            <i class="fas fa-chart-bar mr-3"></i>
                            <span>Reports</span>
                        </a>
                    </nav>
                    <div class="mt-auto">
                        <a href="../logout.php" class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <button class="text-gray-500 focus:outline-none md:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="ml-4 text-xl font-semibold">Rewards Management</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, Admin</span>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <?php if (!empty($message)): ?>
                <div class="mb-4 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Manage Rewards</h2>
                    <a href="add_reward.php" class="bg-primary hover:bg-opacity-90 text-white py-2 px-4 rounded-lg">
                        <i class="fas fa-plus mr-2"></i> Add New Reward
                    </a>
                </div>

                <!-- Rewards List -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reward</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($rewards as $reward): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-primary bg-opacity-20 rounded-full flex items-center justify-center">
                                            <i class="fas fa-gift text-primary"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($reward['title']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo number_format($reward['points_required']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($reward['category']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo $reward['user_type'] === 'startup' ? 'bg-blue-100 text-blue-800' : 
                                            ($reward['user_type'] === 'corporate' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800'); ?>">
                                        <?php echo ucfirst($reward['user_type']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $reward['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                        <?php echo ucfirst($reward['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="edit_reward.php?id=<?php echo $reward['id']; ?>" class="text-primary hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                                    <a href="?toggle_status=<?php echo $reward['id']; ?>" class="text-yellow-600 hover:text-yellow-900 mr-3" onclick="return confirm('Are you sure you want to toggle the status of this reward?')">
                                        <?php echo $reward['status'] === 'active' ? '<i class="fas fa-toggle-on"></i>' : '<i class="fas fa-toggle-off"></i>'; ?>
                                    </a>
                                    <a href="?delete_reward=<?php echo $reward['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this reward? This action cannot be undone.')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($rewards)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No rewards found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium"><?php echo $offset + 1; ?></span> to <span class="font-medium"><?php echo min($offset + $limit, $totalRewards); ?></span> of <span class="font-medium"><?php echo $totalRewards; ?></span> rewards
                    </div>
                    <div class="flex space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="px-3 py-1 border rounded text-sm text-gray-700">Previous</a>
                        <?php endif; ?>
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="px-3 py-1 border rounded text-sm <?php echo $i === $page ? 'bg-primary text-white' : 'text-gray-700'; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="px-3 py-1 border rounded text-sm text-gray-700">Next</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Recent Redemptions -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-6">Recent Redemptions</h2>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reward</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points Spent</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($redemptions as $redemption): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($redemption['username']); ?></div>
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?php echo $redemption['user_type'] === 'startup' ? 'bg-blue-100 text-blue-800' : 
                                                    ($redemption['user_type'] === 'corporate' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800'); ?>">
                                                <?php echo ucfirst($redemption['user_type']); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo htmlspecialchars($redemption['title']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo number_format($redemption['points_spent']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo date('M j, Y g:i A', strtotime($redemption['redemption_date'])); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php echo $redemption['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                                ($redemption['status'] === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                            <?php echo ucfirst($redemption['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php if ($redemption['status'] === 'pending'): ?>
                                            <a href="?complete_redemption=<?php echo $redemption['id']; ?>" class="text-green-600 hover:text-green-900 mr-3" onclick="return confirm('Are you sure you want to mark this redemption as completed?')">
                                                <i class="fas fa-check"></i> Complete
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400"><i class="fas fa-check"></i> Processed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($redemptions)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No redemptions found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 