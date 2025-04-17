<?php
// Check if user is already logged in, redirect if needed
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../../dashboard/corporate.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Registration - Biz-Fusion</title>
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
    <nav class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="../../index.php">
                    <img src="../../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="../../index.php" class="hover:text-primary transition">Home</a>
                <a href="../../about.php" class="hover:text-primary transition">About</a>
                <a href="../../services.php" class="hover:text-primary transition">Services</a>
                <a href="../../success-stories.php" class="hover:text-primary transition">Success Stories</a>
                <a href="../../contact.php" class="hover:text-primary transition">Contact</a>
            </div>
            <div>
                <a href="../../login.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Registration Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold mb-6">Corporate <span class="text-secondary">Registration</span></h1>
                <p class="text-gray-300 text-lg">Join our platform to discover innovative startups, find solutions to your challenges, and drive digital transformation.</p>
            </div>

            <div class="bg-dark bg-opacity-50 rounded-xl p-8 md:p-12">
                <?php 
                // Display errors if any
                if (isset($_SESSION["register_errors"]) && !empty($_SESSION["register_errors"])) {
                    echo '<div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-300 px-6 py-4 rounded-lg mb-8">';
                    echo '<div class="flex items-center">';
                    echo '<i class="fas fa-exclamation-circle text-xl mr-2"></i>';
                    echo '<div>';
                    echo '<h3 class="font-semibold">Registration Error</h3>';
                    echo '<ul class="list-disc list-inside">';
                    foreach ($_SESSION["register_errors"] as $error) {
                        echo '<li>' . htmlspecialchars($error) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    // Clear errors after displaying
                    unset($_SESSION["register_errors"]);
                }
                ?>
                <form action="register-process.php" method="post">
                    <input type="hidden" name="user_type" value="corporate">
                    <h2 class="text-2xl font-semibold mb-6">Account Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-300 mb-2">First Name*</label>
                            <input type="text" id="first_name" name="first_name" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-300 mb-2">Last Name*</label>
                            <input type="text" id="last_name" name="last_name" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Work Email Address*</label>
                        <input type="email" id="email" name="email" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password*</label>
                            <input type="password" id="password" name="password" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                            <p class="text-xs text-gray-400 mt-1">Must be at least 8 characters with 1 uppercase, 1 number, and 1 special character</p>
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password*</label>
                            <input type="password" id="confirm_password" name="confirm_password" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">Company Name*</label>
                        <input type="text" id="company_name" name="company_name" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    
                    <div class="mb-6">
                        <label for="job_title" class="block text-sm font-medium text-gray-300 mb-2">Job Title*</label>
                        <input type="text" id="job_title" name="job_title" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    
                    <div class="mb-8">
                        <label class="flex items-center">
                            <input type="checkbox" name="terms" required class="rounded text-secondary focus:ring-secondary">
                            <span class="ml-2 text-sm text-gray-300">I agree to the <a href="#" class="text-secondary hover:underline">Terms of Service</a> and <a href="#" class="text-secondary hover:underline">Privacy Policy</a>*</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <a href="../../index.php" class="text-gray-400 hover:text-white transition">Cancel</a>
                        <button type="submit" class="bg-secondary hover:bg-opacity-90 text-white font-medium py-3 px-8 rounded-lg transition">Register</button>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-400">Already have an account? <a href="../../login.php" class="text-secondary hover:underline">Sign in</a></p>
                <p class="text-gray-400 mt-2">Are you a startup? <a href="startup-register.php" class="text-secondary hover:underline">Register as a Startup</a></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="../../public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-8 mb-4">
                    <p class="text-gray-400">Connecting innovative startups with established corporations for mutual growth and success.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="../../index.php" class="hover:text-primary transition">Home</a></li>
                        <li><a href="../../about.php" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="../../services.php" class="hover:text-primary transition">Services</a></li>
                        <li><a href="../../success-stories.php" class="hover:text-primary transition">Success Stories</a></li>
                        <li><a href="../../contact.php" class="hover:text-primary transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-primary transition">Blog</a></li>
                        <li><a href="#" class="hover:text-primary transition">Guides</a></li>
                        <li><a href="#" class="hover:text-primary transition">Events</a></li>
                        <li><a href="#" class="hover:text-primary transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>info@bizfusion.com</li>
                        <li>+1 (555) 123-4567</li>
                        <li>123 Innovation Street, San Francisco, CA 94103</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; <?php echo date('Y'); ?> Biz-Fusion. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 