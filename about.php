<?php
// Include database connection
require_once 'backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Biz-Fusion</title>
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
                <a href="index.php">
                    <img src="public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="index.php" class="hover:text-primary transition">Home</a>
                <a href="about.php" class="text-primary transition">About</a>
                <a href="services.php" class="hover:text-primary transition">Services</a>
                <a href="success-stories.php" class="hover:text-primary transition">Success Stories</a>
                <a href="contact.php" class="hover:text-primary transition">Contact</a>
            </div>
            <div>
                <a href="login.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold mb-6">About <span class="text-primary">Biz-Fusion</span></h1>
            <p class="text-xl text-gray-300 mb-6">Connecting innovators with opportunity, creating powerful partnerships for mutual growth.</p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="container mx-auto px-6 py-16">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <img src="public/images/bizfusion_square_bg.png" alt="Biz-Fusion Team" class="rounded-xl shadow-lg">
            </div>
            <div class="md:w-1/2 md:pl-12">
                <h2 class="font-['Playfair_Display'] text-3xl font-bold mb-6">Our Story</h2>
                <p class="text-gray-300 mb-4">Biz-Fusion was founded in 2023 with a simple mission: bridge the gap between innovative startups and established corporations to create powerful partnerships that drive growth and innovation.</p>
                <p class="text-gray-300 mb-4">We noticed that while startups were creating groundbreaking solutions, they often struggled to find the right corporate partners to scale. Meanwhile, corporations were looking for fresh innovations but faced challenges in discovering and vetting the right startups.</p>
                <p class="text-gray-300">Our platform changes that dynamic by using advanced matching algorithms and a community-focused approach to create meaningful business relationships that benefit both parties.</p>
            </div>
        </div>
    </section>

    <!-- Our Mission -->
    <section class="container mx-auto px-6 py-16 bg-dark bg-opacity-30 rounded-3xl my-16">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="font-['Playfair_Display'] text-3xl font-bold mb-6">Our Mission</h2>
            <p class="text-xl text-gray-300 mb-8">To accelerate innovation and growth by creating the most effective ecosystem for startup-corporate collaboration.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div>
                    <div class="w-16 h-16 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Connect</h3>
                    <p class="text-gray-300">Facilitate meaningful connections between startups and corporations</p>
                </div>
                <div>
                    <div class="w-16 h-16 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Accelerate</h3>
                    <p class="text-gray-300">Speed up innovation cycles and market entry for new solutions</p>
                </div>
                <div>
                    <div class="w-16 h-16 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Grow</h3>
                    <p class="text-gray-300">Enable sustainable business growth through strategic collaboration</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="font-['Playfair_Display'] text-3xl font-bold text-center mb-12">Our Leadership Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-dark bg-opacity-50 rounded-xl p-6 text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-4">
                    <img src="https://media.licdn.com/dms/image/v2/D4E03AQFl9ntTxr4oMg/profile-displayphoto-shrink_400_400/profile-displayphoto-shrink_400_400/0/1689265590795?e=1750291200&v=beta&t=n1cgTPlPKr_XOh1Vy5DWDjWnrWWWnxqek3UzKSyoBDY" alt="Michael Chen" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-semibold mb-1">Ayush Sharma</h3>
                <p class="text-primary mb-3">CEO & Founder</p>
                <p class="text-gray-300">Former tech executive with 15+ years experience in corporate innovation.</p>
            </div>
            <div class="bg-dark bg-opacity-50 rounded-xl p-6 text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-4">
                    <img src="https://media.licdn.com/dms/image/v2/D5603AQFZZCnfF3hMBg/profile-displayphoto-shrink_400_400/profile-displayphoto-shrink_400_400/0/1725126576545?e=1750291200&v=beta&t=haV-GLRX7PHTjgeDjlU1SB7XrDHhKS7OHrSYKZ_AqT4" alt="Sarah Johnson" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-semibold mb-1">Kartik Choudhary</h3>
                <p class="text-primary mb-3">CTO</p>
                <p class="text-gray-300">Tech entrepreneur with multiple successful exits and expertise in AI matching algorithms.</p>
            </div>
            <div class="bg-dark bg-opacity-50 rounded-xl p-6 text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-4">
                    <img src="https://media.licdn.com/dms/image/v2/D4D03AQE26AQx6GypUQ/profile-displayphoto-shrink_400_400/profile-displayphoto-shrink_400_400/0/1695701012684?e=1750291200&v=beta&t=DG4Xq-nSmhOzkgLxHwU5jmEhdKIJ0hKhdvYvhBOHSuo" alt="David Patel" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-semibold mb-1">Rohit Kumar</h3>
                <p class="text-primary mb-3">Head of Partnerships</p>
                <p class="text-gray-300">Previously led corporate development at Fortune 500 companies with a focus on startup acquisition.</p>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="container mx-auto px-6 py-16 bg-dark bg-opacity-30 rounded-3xl my-16">
        <h2 class="font-['Playfair_Display'] text-3xl font-bold text-center mb-12">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="flex">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center shrink-0 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Trust & Transparency</h3>
                    <p class="text-gray-300">We believe in creating a transparent ecosystem where businesses can connect with confidence.</p>
                </div>
            </div>
            <div class="flex">
                <div class="bg-secondary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center shrink-0 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Efficiency</h3>
                    <p class="text-gray-300">We're committed to creating the fastest path from introduction to collaboration.</p>
                </div>
            </div>
            <div class="flex">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center shrink-0 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Mutual Benefit</h3>
                    <p class="text-gray-300">Every connection we facilitate aims to create value for all parties involved.</p>
                </div>
            </div>
            <div class="flex">
                <div class="bg-secondary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center shrink-0 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">Ecosystem Building</h3>
                    <p class="text-gray-300">We're creating a community where innovation thrives through collaboration.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-6 py-16 my-8">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Ready to Join the Biz-Fusion Community?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Whether you're a startup looking to scale or a corporation seeking innovation, Biz-Fusion is your platform for growth.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="lib/auth/startup-register.php" class="bg-white text-primary hover:bg-opacity-90 px-8 py-3 rounded-full transition font-medium">Register as Startup</a>
                <a href="lib/auth/corporate-register.php" class="border border-white hover:bg-white hover:bg-opacity-10 px-8 py-3 rounded-full transition font-medium">Register as Corporate</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-8 mb-4">
                    <p class="text-gray-400">Connecting innovative startups with established corporations for mutual growth and success.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="index.php" class="hover:text-primary transition">Home</a></li>
                        <li><a href="about.php" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="services.php" class="hover:text-primary transition">Services</a></li>
                        <li><a href="success-stories.php" class="hover:text-primary transition">Success Stories</a></li>
                        <li><a href="contact.php" class="hover:text-primary transition">Contact</a></li>
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
                        <li>+91 7060584421</li>
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