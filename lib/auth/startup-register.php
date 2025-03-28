<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Registration - Biz-Fusion</title>
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
                <a href="index.html">
                    <img src="bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="index.html" class="hover:text-primary transition">Home</a>
                <a href="about.html" class="hover:text-primary transition">About</a>
                <a href="services.html" class="hover:text-primary transition">Services</a>
                <a href="success-stories.html" class="hover:text-primary transition">Success Stories</a>
                <a href="contact.html" class="hover:text-primary transition">Contact</a>
            </div>
            <div>
                <a href="login.html" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Registration Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold mb-6">Startup <span class="text-primary">Registration</span></h1>
                <p class="text-gray-300 text-lg">Join our platform to connect with established corporations, access resources, and accelerate your growth.</p>
            </div>

            <div class="bg-dark bg-opacity-50 rounded-xl p-8 md:p-12">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-full max-w-md">
                        <div class="flex justify-between">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center mx-auto">1</div>
                                <p class="text-sm mt-2">Account</p>
                            </div>
                            <div class="flex-1 flex items-center justify-center">
                                <div class="h-1 w-full bg-primary bg-opacity-30"></div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-primary bg-opacity-30 text-white rounded-full flex items-center justify-center mx-auto">2</div>
                                <p class="text-sm mt-2">Company</p>
                            </div>
                            <div class="flex-1 flex items-center justify-center">
                                <div class="h-1 w-full bg-primary bg-opacity-30"></div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-primary bg-opacity-30 text-white rounded-full flex items-center justify-center mx-auto">3</div>
                                <p class="text-sm mt-2">Profile</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form>
                    <h2 class="text-2xl font-semibold mb-6">Account Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-300 mb-2">First Name*</label>
                            <input type="text" id="first_name" name="first_name" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-300 mb-2">Last Name*</label>
                            <input type="text" id="last_name" name="last_name" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address*</label>
                        <input type="email" id="email" name="email" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password*</label>
                            <input type="password" id="password" name="password" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                            <p class="text-xs text-gray-400 mt-1">Must be at least 8 characters with 1 uppercase, 1 number, and 1 special character</p>
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password*</label>
                            <input type="password" id="confirm_password" name="confirm_password" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    
                    <div class="mb-8">
                        <label class="flex items-center">
                            <input type="checkbox" required class="rounded text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-300">I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a>*</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <a href="index.html" class="text-gray-400 hover:text-white transition">Cancel</a>
                        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white font-medium py-3 px-8 rounded-lg transition">Continue to Company Info</button>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-400">Already have an account? <a href="login.html" class="text-primary hover:underline">Sign in</a></p>
                <p class="text-gray-400 mt-2">Are you a corporate? <a href="corporate-register.html" class="text-primary hover:underline">Register as a Corporate</a></p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Benefits for Startups</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <div class="bg-primary bg-opacity-20 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Corporate Connections</h3>
                <p class="text-gray-300">Get matched with established corporations looking for innovative solutions in your industry.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <div class="bg-primary bg-opacity-20 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Funding Opportunities</h3>
                <p class="text-gray-300">Access investment opportunities, grants, and financial resources to fuel your growth.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <div class="bg-primary bg-opacity-20 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Market Expansion</h3>
                <p class="text-gray-300">Scale your business faster by leveraging corporate partnerships to reach new markets and customers.</p>
            </div>
        </div>
    </section>

    <!-- Testimonial -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-dark bg-opacity-50 rounded-xl p-8 md:p-12">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3 mb-8 md:mb-0 flex justify-center">
                    <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="Emma Rodriguez" class="w-32 h-32 rounded-full border-4 border-primary">
                </div>
                <div class="md:w-2/3 md:pl-12">
                    <svg class="h-12 w-12 text-primary opacity-30 mb-4" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                    </svg>
                    <p class="text-xl text-gray-300 mb-6">Biz-Fusion was a game-changer for our startup. Within two months of joining, we secured a partnership with a Fortune 500 company that completely transformed our business trajectory.</p>
                    <div>
                        <h4 class="font-semibold">Emma Rodriguez</h4>
                        <p class="text-gray-400">CEO, InnovateTech</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Frequently Asked Questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">How long does the registration process take?</h3>
                <p class="text-gray-300">The initial registration takes about 10-15 minutes. After that, you'll need to complete your company profile which may take an additional 20-30 minutes.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">Is there a fee to join as a startup?</h3>
                <p class="text-gray-300">Basic membership is free. Premium features and enhanced matching capabilities are available through our subscription plans.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">How soon can I expect to be matched?</h3>
                <p class="text-gray-300">Most startups receive their first potential matches within 48 hours of completing their profile, depending on your industry and specific needs.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">What information do I need to provide?</h3>
                <p class="text-gray-300">You'll need to provide basic company information, your industry, stage of development, funding history, and details about your products or services.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-8 mb-4">
                    <p class="text-gray-400">Connecting innovative startups with established corporations for mutual growth and success.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="index.html" class="hover:text-primary transition">Home</a></li>
                        <li><a href="about.html" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="services.html" class="hover:text-primary transition">Services</a></li>
                        <li><a href="success-stories.html" class="hover:text-primary transition">Success Stories</a></li>
                        <li><a href="contact.html" class="hover:text-primary transition">Contact</a></li>
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
                <p>&copy; 2023 Biz-Fusion. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 