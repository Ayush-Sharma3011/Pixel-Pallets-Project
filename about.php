<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Biz-Fusion</title>
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
                <a href="about.html" class="text-primary transition">About</a>
                <a href="services.html" class="hover:text-primary transition">Services</a>
                <a href="success-stories.html" class="hover:text-primary transition">Success Stories</a>
                <a href="contact.html" class="hover:text-primary transition">Contact</a>
            </div>
            <div>
                <a href="login.html" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold mb-6">About Biz-Fusion</h1>
            <p class="text-gray-300 text-lg mb-8">Bridging the gap between innovation and established business</p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="container mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <img src="bizfusion_bg.png" alt="Our Story" class="rounded-xl shadow-2xl">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Our Story</h2>
                <p class="text-gray-300 mb-4">Biz-Fusion was founded in 2020 with a simple yet powerful vision: to create a world where startups and corporations can easily collaborate to drive innovation and growth.</p>
                <p class="text-gray-300 mb-4">Our founders, a team of entrepreneurs and corporate executives, experienced firsthand the challenges of building bridges between innovative startups and established businesses. They recognized that while startups offer fresh ideas and agility, corporations provide scale, resources, and market access.</p>
                <p class="text-gray-300">What began as a small matchmaking service has evolved into a comprehensive platform that has facilitated over 500 successful partnerships, raised $100M+ in funding for startups, and helped corporations launch dozens of innovative products and services.</p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="container mx-auto px-6 py-16 bg-dark bg-opacity-30 rounded-2xl my-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="p-8">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-['Playfair_Display'] font-bold mb-4">Our Mission</h3>
                <p class="text-gray-300">To create a thriving ecosystem where startups and corporations collaborate seamlessly, driving innovation, growth, and positive impact in the global business landscape.</p>
            </div>
            <div class="p-8">
                <div class="bg-secondary bg-opacity-20 p-3 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-['Playfair_Display'] font-bold mb-4">Our Vision</h3>
                <p class="text-gray-300">A world where the barriers between startups and corporations are eliminated, creating a fluid exchange of ideas, resources, and opportunities that accelerates innovation and creates sustainable business growth.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden hover:transform hover:scale-105 transition duration-300">
                <div class="h-64 bg-gray-700"></div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-1">Alex Morgan</h3>
                    <p class="text-secondary mb-4">CEO & Co-Founder</p>
                    <p class="text-gray-300 mb-4">Former startup founder with 3 successful exits and 15+ years of experience in tech entrepreneurship.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 2 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden hover:transform hover:scale-105 transition duration-300">
                <div class="h-64 bg-gray-700"></div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-1">Sophia Chen</h3>
                    <p class="text-secondary mb-4">CTO & Co-Founder</p>
                    <p class="text-gray-300 mb-4">Former VP of Engineering at a Fortune 100 tech company with expertise in AI and machine learning.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 3 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden hover:transform hover:scale-105 transition duration-300">
                <div class="h-64 bg-gray-700"></div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-1">Marcus Johnson</h3>
                    <p class="text-secondary mb-4">Chief Business Officer</p>
                    <p class="text-gray-300 mb-4">20+ years in corporate innovation and venture capital with experience across multiple industries.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="container mx-auto px-6 py-16 bg-dark bg-opacity-30 rounded-2xl my-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-6 text-center">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Collaboration</h3>
                <p class="text-gray-300">We believe in the power of partnerships to create value greater than the sum of its parts.</p>
            </div>
            <div class="p-6 text-center">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Innovation</h3>
                <p class="text-gray-300">We embrace new ideas and approaches that challenge the status quo and drive progress.</p>
            </div>
            <div class="p-6 text-center">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Trust</h3>
                <p class="text-gray-300">We build relationships based on transparency, integrity, and mutual respect.</p>
            </div>
            <div class="p-6 text-center">
                <div class="bg-primary bg-opacity-20 p-3 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Impact</h3>
                <p class="text-gray-300">We measure our success by the tangible value we create for our partners and society.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-6 py-16 my-8">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Join Our Growing Community</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Be part of a network that's reshaping how businesses collaborate and innovate together.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="startup-register.html" class="bg-white text-primary hover:bg-opacity-90 px-8 py-3 rounded-full transition font-medium">Register as Startup</a>
                <a href="corporate-register.html" class="border border-white hover:bg-white hover:bg-opacity-10 px-8 py-3 rounded-full transition font-medium">Register as Corporate</a>
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