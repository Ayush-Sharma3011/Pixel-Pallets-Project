<?php
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

// Process new message submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["receiver_id"]) && isset($_POST["message"])) {
    $receiver_id = $_POST["receiver_id"];
    $message_text = trim($_POST["message"]);
    $partnership_id = $_POST["partnership_id"];
    
    if (!empty($message_text)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, partnership_id, message, created_at) 
                               VALUES (:sender_id, :receiver_id, :partnership_id, :message, NOW())");
        $stmt->bindParam(":sender_id", $user_id);
        $stmt->bindParam(":receiver_id", $receiver_id);
        $stmt->bindParam(":partnership_id", $partnership_id);
        $stmt->bindParam(":message", $message_text);
        
        if ($stmt->execute()) {
            // Update last activity on partnership
            $update_stmt = $conn->prepare("UPDATE partnerships SET last_activity = NOW() WHERE id = :partnership_id");
            $update_stmt->bindParam(":partnership_id", $partnership_id);
            $update_stmt->execute();
            
            // Redirect to avoid form resubmission
            header("Location: messages.php?partner_id=" . $receiver_id);
            exit;
        }
    }
}

// Get list of all connections (partnerships)
if ($user_type == "startup") {
    $stmt = $conn->prepare("SELECT p.id as partnership_id, p.status, p.last_activity, u.id as partner_id, 
                           u.company_name, u.industry, u.username 
                           FROM partnerships p 
                           JOIN users u ON p.corporate_id = u.id 
                           WHERE p.startup_id = :user_id 
                           ORDER BY p.last_activity DESC");
} else {
    $stmt = $conn->prepare("SELECT p.id as partnership_id, p.status, p.last_activity, u.id as partner_id, 
                           u.company_name, u.industry, u.username 
                           FROM partnerships p 
                           JOIN users u ON p.startup_id = u.id 
                           WHERE p.corporate_id = :user_id 
                           ORDER BY p.last_activity DESC");
}
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$connections = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get current conversation if partner_id is set
$current_partner = null;
$messages = [];
$partnership_id = null;

if (isset($_GET["partner_id"]) && !empty($_GET["partner_id"])) {
    $partner_id = $_GET["partner_id"];
    
    // Get partner info
    $stmt = $conn->prepare("SELECT id, company_name, industry, username, user_type FROM users WHERE id = :partner_id");
    $stmt->bindParam(":partner_id", $partner_id);
    $stmt->execute();
    $current_partner = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($current_partner) {
        // Get partnership ID
        if ($user_type == "startup") {
            $stmt = $conn->prepare("SELECT id FROM partnerships WHERE startup_id = :user_id AND corporate_id = :partner_id");
        } else {
            $stmt = $conn->prepare("SELECT id FROM partnerships WHERE corporate_id = :user_id AND startup_id = :partner_id");
        }
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":partner_id", $partner_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $partnership_id = $result['id'];
            
            // Get conversation messages
            $stmt = $conn->prepare("SELECT m.*, u.username, u.company_name 
                                   FROM messages m 
                                   JOIN users u ON m.sender_id = u.id 
                                   WHERE m.partnership_id = :partnership_id 
                                   ORDER BY m.created_at ASC");
            $stmt->bindParam(":partnership_id", $partnership_id);
            $stmt->execute();
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Biz-Fusion</title>
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
            <h1 class="text-2xl font-bold">Messages</h1>
            <a href="<?php echo $user_type == "startup" ? "startdash.php" : "corpdash.php"; ?>" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition">Back to Dashboard</a>
        </div>
        
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Connections List (Sidebar) -->
            <div class="w-full md:w-1/3 lg:w-1/4">
                <div class="bg-dark bg-opacity-50 rounded-xl p-4 h-[600px] overflow-y-auto">
                    <h2 class="font-semibold mb-4">Your Connections</h2>
                    
                    <?php if (count($connections) > 0): ?>
                        <div class="space-y-2">
                            <?php foreach ($connections as $connection): ?>
                                <a href="messages.php?partner_id=<?php echo $connection['partner_id']; ?>" 
                                   class="block p-3 rounded-lg transition 
                                         <?php echo (isset($_GET['partner_id']) && $_GET['partner_id'] == $connection['partner_id']) 
                                               ? 'bg-primary bg-opacity-20' 
                                               : 'hover:bg-gray-800'; ?>">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-<?php echo $user_type == 'startup' ? 'secondary' : 'primary'; ?> rounded-full flex items-center justify-center text-lg font-bold mr-3">
                                            <?php echo substr($connection['username'], 0, 1); ?>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-sm"><?php echo htmlspecialchars($connection['company_name']); ?></h3>
                                            <p class="text-gray-400 text-xs"><?php echo htmlspecialchars($connection['industry']); ?></p>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6">
                            <p class="text-gray-400 text-sm mb-4">You don't have any connections yet</p>
                            <a href="connect.php" class="bg-<?php echo $user_type == 'startup' ? 'primary' : 'secondary'; ?> hover:bg-opacity-90 text-white py-2 px-4 rounded-lg transition text-sm">
                                Find Connections
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Messages Area -->
            <div class="w-full md:w-2/3 lg:w-3/4">
                <?php if ($current_partner && $partnership_id): ?>
                    <div class="bg-dark bg-opacity-50 rounded-xl h-[600px] flex flex-col">
                        <!-- Conversation Header -->
                        <div class="p-4 border-b border-gray-700 flex items-center">
                            <div class="w-10 h-10 bg-<?php echo $current_partner['user_type'] == 'startup' ? 'primary' : 'secondary'; ?> rounded-full flex items-center justify-center text-lg font-bold mr-3">
                                <?php echo substr($current_partner['username'], 0, 1); ?>
                            </div>
                            <div>
                                <h2 class="font-semibold"><?php echo htmlspecialchars($current_partner['company_name']); ?></h2>
                                <p class="text-gray-400 text-xs"><?php echo htmlspecialchars($current_partner['industry']); ?></p>
                            </div>
                        </div>
                        
                        <!-- Messages Area -->
                        <div class="flex-grow p-4 overflow-y-auto" id="message-container">
                            <?php if (count($messages) > 0): ?>
                                <?php foreach ($messages as $message): ?>
                                    <div class="mb-4 <?php echo ($message['sender_id'] == $user_id) ? 'text-right' : ''; ?>">
                                        <div class="inline-block max-w-[80%] 
                                                  <?php echo ($message['sender_id'] == $user_id) 
                                                        ? 'bg-primary bg-opacity-50 rounded-tl-xl rounded-tr-xl rounded-bl-xl' 
                                                        : 'bg-gray-700 rounded-tl-xl rounded-tr-xl rounded-br-xl'; ?> 
                                                  p-3">
                                            <p class="text-sm"><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            <?php echo date('M j, g:i a', strtotime($message['created_at'])); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-6">
                                    <p class="text-gray-400">No messages yet. Start the conversation!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Message Input -->
                        <form method="POST" action="messages.php?partner_id=<?php echo $current_partner['id']; ?>" class="p-4 border-t border-gray-700">
                            <input type="hidden" name="receiver_id" value="<?php echo $current_partner['id']; ?>">
                            <input type="hidden" name="partnership_id" value="<?php echo $partnership_id; ?>">
                            <div class="flex gap-2">
                                <textarea name="message" placeholder="Type your message..." class="flex-grow bg-gray-800 border border-gray-700 rounded-lg p-3 text-white focus:ring-primary focus:border-primary resize-none" rows="2" required></textarea>
                                <button type="submit" class="bg-<?php echo $user_type == 'startup' ? 'primary' : 'secondary'; ?> hover:bg-opacity-90 text-white py-2 px-4 rounded-lg transition self-end">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="bg-dark bg-opacity-50 rounded-xl h-[600px] flex flex-col items-center justify-center p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h2 class="text-xl font-semibold mb-2">Your Messages</h2>
                        <p class="text-gray-400 mb-6">Select a connection to start chatting or find new connections</p>
                        <a href="connect.php" class="bg-<?php echo $user_type == 'startup' ? 'primary' : 'secondary'; ?> hover:bg-opacity-90 text-white py-2 px-6 rounded-lg transition">
                            Find Connections
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to bottom of message container
        window.onload = function() {
            const messageContainer = document.getElementById('message-container');
            if (messageContainer) {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
        };
    </script>
</body>
</html> 