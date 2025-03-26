<?php
/**
 * Header Template
 * 
 * This file contains the standard header used across all pages 
 * including the head section, navigation, and points display
 */

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$user_type = $is_logged_in ? $_SESSION['user_type'] : '';
$total_points = $is_logged_in ? $_SESSION['total_points'] : 0;
$username = $is_logged_in ? $_SESSION['username'] : '';

// Get page title
$page_title = isset($page_title) ? $page_title . ' - Biz-Fusion' : 'Biz-Fusion';

// Get active page for navigation
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
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
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="font-['Poppins'] bg-gradient-to-t from-[#0A0F1D] to-[#000000] text-white min-h-screen">
    <?php if ($is_logged_in): ?>
        <!-- Include Points Display for logged-in users -->
        <?php include_once __DIR__ . '/points_display.php'; ?>
    <?php endif; ?>
    
    <!-- Navigation -->
    <nav class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="/index.php">
                    <img src="/public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="/index.php" class="<?php echo $current_page == 'index.php' ? 'text-primary' : 'hover:text-primary'; ?> transition">Home</a>
                <a href="/about.php" class="<?php echo $current_page == 'about.php' ? 'text-primary' : 'hover:text-primary'; ?> transition">About</a>
                <a href="/services.php" class="<?php echo $current_page == 'services.php' ? 'text-primary' : 'hover:text-primary'; ?> transition">Services</a>
                <a href="/success-stories.php" class="<?php echo $current_page == 'success-stories.php' ? 'text-primary' : 'hover:text-primary'; ?> transition">Success Stories</a>
                <a href="/contact.php" class="<?php echo $current_page == 'contact.php' ? 'text-primary' : 'hover:text-primary'; ?> transition">Contact</a>
            </div>
            <div>
                <?php if ($is_logged_in): ?>
                    <div class="flex items-center">
                        <?php if ($user_type == 'startup'): ?>
                            <a href="/dashboard/startup.php" class="mr-4 hover:text-primary transition">Dashboard</a>
                        <?php else: ?>
                            <a href="/dashboard/corporate.php" class="mr-4 hover:text-primary transition">Dashboard</a>
                        <?php endif; ?>
                        <div class="mr-4 bg-dark bg-opacity-50 px-4 py-2 rounded-full">
                            <span class="text-yellow-400 font-semibold"><?php echo $total_points; ?></span> points
                        </div>
                        <a href="/auth/logout.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign Out</a>
                    </div>
                <?php else: ?>
                    <a href="/auth/login.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav> 