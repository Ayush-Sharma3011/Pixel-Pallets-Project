<?php
// Include database connection
require_once 'backend/config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Fetch services from the database
$services = [];
try {
    $stmt = $conn->prepare("SELECT * FROM services ORDER BY id");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    // Handle error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Biz-Fusion</title>
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
                <a href="about.php" class="hover:text-primary transition">About</a>
                <a href="services.php" class="text-primary transition">Services</a>
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
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Our <span class="text-primary">Services</span></h1>
            <p class="text-xl text-gray-300 mb-6">Discover how Biz-Fusion can help your business thrive through powerful partnerships and innovation.</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="container mx-auto px-6 py-16">
        <?php if (count($services) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($services as $service): ?>
                    <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                            <i class="<?php echo htmlspecialchars($service['icon']); ?> text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3"><?php echo htmlspecialchars($service['title']); ?></h3>
                        <p class="text-gray-300"><?php echo htmlspecialchars($service['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Default services if none found in database -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Smart Matching</h3>
                    <p class="text-gray-300">Our AI-powered algorithm connects startups with corporate partners based on mutual interests, technologies, and business objectives.</p>
                </div>
                <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                    <div class="bg-secondary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Verified Partnerships</h3>
                    <p class="text-gray-300">All businesses on our platform undergo thorough verification to ensure safe, transparent, and valuable partnerships.</p>
                </div>
                <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Funding Access</h3>
                    <p class="text-gray-300">Startups gain access to potential investment opportunities, while corporates find innovative solutions to business challenges.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                    <div class="bg-secondary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Events & Networking</h3>
                    <p class="text-gray-300">Access to exclusive virtual and in-person events designed to facilitate meaningful connections between startups and corporates.</p>
                </div>
                <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                    <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Innovation Challenges</h3>
                    <p class="text-gray-300">Corporates can post innovation challenges, and startups can submit tailored solutions, fostering targeted collaborations.</p>
                </div>
                <div class="bg-dark bg-opacity-50 p-8 rounded-xl hover:transform hover:scale-105 transition duration-300">
                    <div class="bg-secondary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Resources & Guides</h3>
                    <p class="text-gray-300">Access to comprehensive guides, best practices, and resources for successful startup-corporate partnerships.</p>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <!-- How It Works Section -->
    <section class="container mx-auto px-6 py-16 bg-dark bg-opacity-30 rounded-2xl my-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">How Our Services Work</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-primary text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                <h3 class="text-xl font-semibold mb-2">Create Profile</h3>
                <p class="text-gray-300">Build your company profile highlighting your strengths and needs</p>
            </div>
            <div class="text-center">
                <div class="bg-primary text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                <h3 class="text-xl font-semibold mb-2">Get Matched</h3>
                <p class="text-gray-300">Our AI algorithm suggests potential partners based on compatibility</p>
            </div>
            <div class="text-center">
                <div class="bg-primary text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                <h3 class="text-xl font-semibold mb-2">Connect</h3>
                <p class="text-gray-300">Initiate conversations and explore collaboration opportunities</p>
            </div>
            <div class="text-center">
                <div class="bg-primary text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">4</div>
                <h3 class="text-xl font-semibold mb-2">Collaborate</h3>
                <p class="text-gray-300">Form partnerships and grow together with ongoing support</p>
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="login.php" class="bg-primary hover:bg-opacity-90 text-white px-8 py-3 rounded-full transition font-medium">Start Your Journey</a>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-4">Transparent Pricing</h2>
        <p class="text-xl text-center text-gray-300 mb-12 max-w-2xl mx-auto">Choose the plan that fits your business needs and scale as you grow.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Startup Basic -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold mb-2">Startup Basic</h3>
                    <p class="text-gray-400 mb-6">Perfect for early-stage startups</p>
                    <div class="flex items-end mb-6">
                        <span class="text-4xl font-bold">Free</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Create company profile
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            5 corporate matches per month
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Basic analytics
                        </li>
                    </ul>
                    <a href="lib/auth/startup-register.php" class="block text-center bg-white bg-opacity-10 hover:bg-opacity-20 border border-white border-opacity-20 px-6 py-3 rounded-lg transition">Get Started</a>
                </div>
            </div>
            
            <!-- Startup Pro -->
            <div class="bg-gradient-to-b from-primary to-primary/50 rounded-xl overflow-hidden transform scale-105 z-10 shadow-xl">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold mb-2">Startup Pro</h3>
                    <p class="text-gray-200 mb-6">For growing startups seeking more opportunities</p>
                    <div class="flex items-end mb-6">
                        <span class="text-4xl font-bold">$49</span>
                        <span class="text-lg ml-1">/month</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Everything in Basic
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Unlimited matches
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Priority in search results
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Advanced analytics
                        </li>
                    </ul>
                    <a href="lib/auth/startup-register.php" class="block text-center bg-white text-primary font-medium px-6 py-3 rounded-lg transition">Get Started</a>
                </div>
            </div>
            
            <!-- Corporate -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold mb-2">Corporate</h3>
                    <p class="text-gray-400 mb-6">For established companies seeking innovation</p>
                    <div class="flex items-end mb-6">
                        <span class="text-4xl font-bold">$199</span>
                        <span class="text-lg ml-1">/month</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Unlimited startup matches
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Post innovation challenges
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Dedicated account manager
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Advanced analytics & reporting
                        </li>
                    </ul>
                    <a href="lib/auth/corporate-register.php" class="block text-center bg-white bg-opacity-10 hover:bg-opacity-20 border border-white border-opacity-20 px-6 py-3 rounded-lg transition">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-6 py-16 my-8">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of businesses already collaborating and growing through Biz-Fusion's powerful network.</p>
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