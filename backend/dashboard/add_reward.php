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

// Initialize variables
$title = '';
$description = '';
$points_required = '';
$user_type = 'all';
$category = '';
$quantity = '';
$status = 'active';

$message = '';
$messageType = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $points_required = (int)$_POST['points_required'];
    $user_type = $_POST['user_type'];
    $category = trim($_POST['category']);
    $quantity = $_POST['quantity'] === '' ? null : (int)$_POST['quantity'];
    $status = $_POST['status'];
    
    $errors = [];
    
    if (empty($title)) {
        $errors[] = 'Title is required';
    }
    
    if (empty($description)) {
        $errors[] = 'Description is required';
    }
    
    if (empty($points_required) || $points_required <= 0) {
        $errors[] = 'Points required must be a positive number';
    }
    
    if (empty($category)) {
        $errors[] = 'Category is required';
    }
    
    if ($quantity !== null && $quantity < 0) {
        $errors[] = 'Quantity cannot be negative';
    }
    
    // If no errors, insert the reward
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO rewards (title, description, points_required, user_type, category, quantity, status)
                VALUES (:title, :description, :points_required, :user_type, :category, :quantity, :status)
            ");
            
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':points_required', $points_required);
            $stmt->bindParam(':user_type', $user_type);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                $message = 'Reward added successfully';
                $messageType = 'success';
                
                // Reset form fields
                $title = '';
                $description = '';
                $points_required = '';
                $user_type = 'all';
                $category = '';
                $quantity = '';
                $status = 'active';
            } else {
                $message = 'Error adding reward';
                $messageType = 'danger';
            }
        } catch (PDOException $e) {
            $message = 'Database error: ' . $e->getMessage();
            $messageType = 'danger';
        }
    } else {
        $message = 'Please fix the following errors: ' . implode(', ', $errors);
        $messageType = 'danger';
    }
}

// Get existing categories for the dropdown
$stmt = $conn->prepare("SELECT DISTINCT category FROM rewards ORDER BY category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Reward - Admin Dashboard</title>
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
                    <h1 class="ml-4 text-xl font-semibold">Add New Reward</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, Admin</span>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Add New Reward</h2>
                    <a href="rewards.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Rewards
                    </a>
                </div>

                <?php if (!empty($message)): ?>
                <div class="mb-4 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <!-- Add Reward Form -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                    <form method="post" action="">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                
                                <div>
                                    <label for="points_required" class="block text-sm font-medium text-gray-700">Points Required *</label>
                                    <input type="number" id="points_required" name="points_required" value="<?php echo htmlspecialchars($points_required); ?>" required min="1" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                
                                <div>
                                    <label for="user_type" class="block text-sm font-medium text-gray-700">User Type *</label>
                                    <select id="user_type" name="user_type" required 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                        <option value="all" <?php echo $user_type === 'all' ? 'selected' : ''; ?>>All Users</option>
                                        <option value="startup" <?php echo $user_type === 'startup' ? 'selected' : ''; ?>>Startups Only</option>
                                        <option value="corporate" <?php echo $user_type === 'corporate' ? 'selected' : ''; ?>>Corporates Only</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <div class="flex">
                                        <select id="category" name="category" required 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                            <option value="">Select a category or enter a new one</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $category === $cat ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($cat); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Select an existing category or type a new one</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                    <textarea id="description" name="description" rows="5" required 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"><?php echo htmlspecialchars($description); ?></textarea>
                                </div>
                                
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity (leave blank for unlimited)</label>
                                    <input type="number" id="quantity" name="quantity" value="<?php echo $quantity !== null ? htmlspecialchars($quantity) : ''; ?>" min="1" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <p class="text-xs text-gray-500 mt-1">Leave blank for unlimited quantity</p>
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                    <select id="status" name="status" required 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                        <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-primary hover:bg-opacity-90 text-white py-2 px-6 rounded-lg">
                                <i class="fas fa-plus mr-2"></i> Add Reward
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Allow manual entry of category
        document.getElementById('category').addEventListener('change', function() {
            var select = this;
            var value = select.value;
            
            if (value === '') {
                // Create a new input element
                var input = document.createElement('input');
                input.type = 'text';
                input.name = 'category';
                input.id = 'category-input';
                input.className = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50';
                input.placeholder = 'Enter a new category';
                input.required = true;
                
                // Replace select with input
                select.parentNode.replaceChild(input, select);
                input.focus();
            }
        });
    </script>
</body>
</html> 