<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Include database connection
require_once '../backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Get user data
$user_id = $_SESSION["id"];
$user_type = $_SESSION["user_type"];

// Debug information
$debug_info = [];
$debug_info[] = "User ID: " . $user_id . ", User Type: " . $user_type;

// Create connection request if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connect_id"])) {
    $connect_id = $_POST["connect_id"];
    $message = $_POST["message"];
    
    // Determine the relationship based on user type
    if ($user_type == "startup") {
        $startup_id = $user_id;
        $corporate_id = $connect_id;
    } else {
        $startup_id = $connect_id;
        $corporate_id = $user_id;
    }
    
    // Check if connection already exists
    $check_stmt = $conn->prepare("SELECT id FROM partnerships WHERE startup_id = :startup_id AND corporate_id = :corporate_id");
    $check_stmt->bindParam(":startup_id", $startup_id);
    $check_stmt->bindParam(":corporate_id", $corporate_id);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() == 0) {
        try {
            // Create new partnership record
            $stmt = $conn->prepare("INSERT INTO partnerships (startup_id, corporate_id, status, created_at, initial_message) 
                                VALUES (:startup_id, :corporate_id, 'pending', NOW(), :message)");
            $stmt->bindParam(":startup_id", $startup_id);
            $stmt->bindParam(":corporate_id", $corporate_id);
            $stmt->bindParam(":message", $message);
            
            if ($stmt->execute()) {
                // Create initial message in the conversation
                $partnership_id = $conn->lastInsertId();
                $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, partnership_id, message, created_at) 
                                    VALUES (:sender_id, :receiver_id, :partnership_id, :message, NOW())");
                $stmt->bindParam(":sender_id", $user_id);
                $stmt->bindParam(":receiver_id", $connect_id);
                $stmt->bindParam(":partnership_id", $partnership_id);
                $stmt->bindParam(":message", $message);
                $stmt->execute();
                
                $success_message = "Connection request sent successfully!";
            } else {
                $error_message = "Error: Could not send connection request.";
            }
        } catch(PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
            $debug_info[] = "Error creating partnership: " . $e->getMessage();
        }
    } else {
        $error_message = "You already have a connection with this organization.";
    }
}

// First, check if tables exist
try {
    $stmt = $conn->query("SHOW TABLES LIKE 'users'");
    $usersTableExists = $stmt->rowCount() > 0;
    $debug_info[] = "Users table exists: " . ($usersTableExists ? 'Yes' : 'No');
    
    $stmt = $conn->query("SHOW TABLES LIKE 'startup_profiles'");
    $startupTableExists = $stmt->rowCount() > 0;
    $debug_info[] = "Startup profiles table exists: " . ($startupTableExists ? 'Yes' : 'No');
    
    $stmt = $conn->query("SHOW TABLES LIKE 'corporate_profiles'");
    $corporateTableExists = $stmt->rowCount() > 0;
    $debug_info[] = "Corporate profiles table exists: " . ($corporateTableExists ? 'Yes' : 'No');
    
    // Examine users table structure
    if ($usersTableExists) {
        $stmt = $conn->query("DESCRIBE users");
        $userFields = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $userFields[] = $row['Field'];
        }
        $debug_info[] = "Users table fields: " . implode(", ", $userFields);
    }
} catch(PDOException $e) {
    $debug_info[] = "Error checking tables: " . $e->getMessage();
}

// Get list of active organizations based on user type
$organizations = [];
try {
    if ($user_type == "startup") {
        // For startups, show corporations
        $stmt = $conn->prepare("SELECT u.id, u.company_name, u.industry, u.username 
                               FROM users u 
                               WHERE u.user_type = 'corporate' 
                               AND u.id NOT IN (
                                    SELECT corporate_id FROM partnerships WHERE startup_id = :user_id
                               )
                               ORDER BY u.company_name");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $organizations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $debug_info[] = "Found " . count($organizations) . " corporate organizations";
        
        // Try to get additional corporate profile information if available
        if ($corporateTableExists && count($organizations) > 0) {
            foreach ($organizations as $key => $org) {
                $stmt = $conn->prepare("SELECT description, website_url, founding_year, company_size 
                                       FROM corporate_profiles 
                                       WHERE user_id = :user_id");
                $stmt->bindParam(":user_id", $org['id']);
                $stmt->execute();
                if ($profile = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $organizations[$key] = array_merge($organizations[$key], $profile);
                }
            }
        }
    } else {
        // For corporations, show startups
        $stmt = $conn->prepare("SELECT u.id, u.company_name, u.industry, u.username 
                               FROM users u 
                               WHERE u.user_type = 'startup' 
                               AND u.id NOT IN (
                                    SELECT startup_id FROM partnerships WHERE corporate_id = :user_id
                               )
                               ORDER BY u.company_name");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $organizations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $debug_info[] = "Found " . count($organizations) . " startup organizations";
        
        // Try to get additional startup profile information if available
        if ($startupTableExists && count($organizations) > 0) {
            foreach ($organizations as $key => $org) {
                $stmt = $conn->prepare("SELECT description, website_url, founding_year, funding_stage 
                                       FROM startup_profiles 
                                       WHERE user_id = :user_id");
                $stmt->bindParam(":user_id", $org['id']);
                $stmt->execute();
                if ($profile = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $organizations[$key] = array_merge($organizations[$key], $profile);
                }
            }
        }
    }
} catch(PDOException $e) {
    $debug_info[] = "Error fetching organizations: " . $e->getMessage();
    $error_message = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect - Biz-Fusion</title>
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
<body class="font-['Poppins'] bg-gradient-to-t from-[#0A0F1D] to-[#000000] text-white min-h-screen">
    <!-- Navigation -->
    <nav class="bg-dark bg-opacity-90 py-4 shadow-md">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <a href="../index.php">
                    <img src="../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-8">
                </a>
                <span class="ml-3 text-lg font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <?php if ($user_type == "startup"): ?>
                    <a href="startdash.php" class="hover:text-primary transition">Dashboard</a>
                <?php else: ?>
                    <a href="corpdash.php" class="hover:text-primary transition">Dashboard</a>
                <?php endif; ?>
                <a href="../lib/rewards/index.php" class="hover:text-primary transition">Rewards Center</a>
                <a href="profile.php" class="hover:text-primary transition">Profile</a>
                <a href="connect.php" class="hover:text-primary transition">Connect</a>
                <a href="messages.php" class="hover:text-primary transition">Messages</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Connect with <?php echo $user_type == "startup" ? "Corporates" : "Startups"; ?></h1>
            <a href="<?php echo $user_type == "startup" ? "startdash.php" : "corpdash.php"; ?>" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition">Back to Dashboard</a>
        </div>
        
        <?php if (isset($success_message)): ?>
            <div class="bg-green-500 bg-opacity-20 text-green-300 p-4 rounded-lg mb-6">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 bg-opacity-20 text-red-300 p-4 rounded-lg mb-6">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Debug Information (only visible in development) -->
        <?php if (!empty($debug_info)): ?>
            <div class="bg-yellow-500 bg-opacity-20 text-yellow-300 p-4 rounded-lg mb-6">
                <h3 class="font-bold mb-2">Debug Information:</h3>
                <ul class="list-disc pl-5">
                    <?php foreach($debug_info as $info): ?>
                        <li><?php echo $info; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Organization Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (count($organizations) > 0): ?>
                <?php foreach ($organizations as $org): ?>
                    <div class="bg-dark bg-opacity-50 rounded-xl p-6 hover:shadow-lg transition">
                        <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($org['company_name']); ?></h2>
                        <p class="text-gray-400 text-sm mb-3"><?php echo htmlspecialchars($org['industry']); ?></p>
                        
                        <div class="mb-3">
                            <p class="text-sm mb-2"><?php echo isset($org['description']) ? substr(htmlspecialchars($org['description']), 0, 120) . (strlen($org['description']) > 120 ? '...' : '') : 'No description available.'; ?></p>
                            
                            <div class="grid grid-cols-2 gap-2 mt-3 text-xs text-gray-400">
                                <?php if (isset($org['website_url'])): ?>
                                    <div>
                                        <span class="font-medium">Website:</span>
                                        <a href="<?php echo htmlspecialchars($org['website_url']); ?>" target="_blank" class="text-primary hover:underline ml-1"><?php echo preg_replace('#^https?://#', '', htmlspecialchars($org['website_url'])); ?></a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (isset($org['founding_year'])): ?>
                                    <div>
                                        <span class="font-medium">Founded:</span>
                                        <span class="ml-1"><?php echo htmlspecialchars($org['founding_year']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (isset($org['company_size'])): ?>
                                    <div>
                                        <span class="font-medium">Size:</span>
                                        <span class="ml-1"><?php echo htmlspecialchars($org['company_size']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (isset($org['funding_stage'])): ?>
                                    <div>
                                        <span class="font-medium">Funding:</span>
                                        <span class="ml-1"><?php echo htmlspecialchars($org['funding_stage']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <button onclick="openConnectModal(<?php echo $org['id']; ?>, '<?php echo addslashes($org['company_name']); ?>')" class="w-full bg-<?php echo $user_type == 'startup' ? 'primary' : 'secondary'; ?> hover:bg-opacity-90 text-white py-2 rounded-lg transition text-center">
                            Connect
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full bg-dark bg-opacity-50 rounded-xl p-8 text-center">
                    <p class="text-gray-400 mb-4">No available <?php echo $user_type == "startup" ? "corporates" : "startups"; ?> to connect with at this time.</p>
                    <a href="<?php echo $user_type == "startup" ? "startdash.php" : "corpdash.php"; ?>" class="inline-block bg-<?php echo $user_type == 'startup' ? 'primary' : 'secondary'; ?> hover:bg-opacity-90 text-white py-2 px-6 rounded-lg transition">
                        Return to Dashboard
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Connect Modal -->
    <div id="connectModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <div class="bg-dark rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold mb-4">Connect with <span id="orgName"></span></h3>
            
            <form action="connect.php" method="POST">
                <input type="hidden" id="connect_id" name="connect_id" value="">
                
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-400 mb-1">Introduction Message</label>
                    <textarea id="message" name="message" rows="4" class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 text-white focus:ring-primary focus:border-primary" required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeConnectModal()" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-<?php echo $user_type == 'startup' ? 'primary' : 'secondary'; ?> hover:bg-opacity-90 text-white py-2 px-4 rounded-lg transition">
                        Send Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openConnectModal(id, name) {
            document.getElementById('connect_id').value = id;
            document.getElementById('orgName').textContent = name;
            document.getElementById('connectModal').classList.remove('hidden');
        }
        
        function closeConnectModal() {
            document.getElementById('connectModal').classList.add('hidden');
        }
    </script>
</body>
</html> 