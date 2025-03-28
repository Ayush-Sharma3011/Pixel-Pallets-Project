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
                <a href="index.html">
                    <img src="bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-10">
                </a>
                <span class="ml-3 text-xl font-semibold">Biz-Fusion</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="index.html" class="hover:text-primary transition">Home</a>
                <a href="about.html" class="hover:text-primary transition">About</a>
                <a href="services.html" class="text-primary transition">Services</a>
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
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Our <span class="text-primary">Services</span></h1>
            <p class="text-gray-300 text-lg mb-8">We provide comprehensive solutions to connect innovative startups with established corporations, fostering powerful partnerships that drive growth and success.</p>
        </div>
    </section>

    <!-- Main Services -->
    <section class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- For Startups -->
            <div class="bg-dark bg-opacity-50 rounded-xl p-8 transform hover:scale-105 transition duration-300">
                <div class="bg-primary bg-opacity-20 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-['Playfair_Display'] font-bold mb-4">For Startups</h3>
                <ul class="space-y-4 text-gray-300">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>AI-powered corporate partner matching</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Access to corporate innovation needs</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Pitch deck optimization support</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Networking events and workshops</span>
                    </li>
                </ul>
                <button class="mt-8 w-full bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-xl transition">Get Started</button>
            </div>

            <!-- For Corporates -->
            <div class="bg-dark bg-opacity-50 rounded-xl p-8 transform hover:scale-105 transition duration-300">
                <div class="bg-secondary bg-opacity-20 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-['Playfair_Display'] font-bold mb-4">For Corporates</h3>
                <ul class="space-y-4 text-gray-300">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-secondary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Innovation needs posting platform</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-secondary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Startup discovery and screening</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-secondary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Due diligence support</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-secondary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Innovation strategy consulting</span>
                    </li>
                </ul>
                <button class="mt-8 w-full bg-secondary hover:bg-opacity-90 text-white px-6 py-3 rounded-xl transition">Learn More</button>
            </div>

            <!-- Premium Services -->
            <div class="bg-dark bg-opacity-50 rounded-xl p-8 transform hover:scale-105 transition duration-300">
                <div class="bg-purple-600 bg-opacity-20 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-['Playfair_Display'] font-bold mb-4">Premium Services</h3>
                <ul class="space-y-4 text-gray-300">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-purple-600 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Dedicated account manager</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-purple-600 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Priority matching</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-purple-600 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Advanced analytics</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-purple-600 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Custom integration support</span>
                    </li>
                </ul>
                <button class="mt-8 w-full border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:bg-opacity-10 px-6 py-3 rounded-xl transition">Contact Sales</button>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-16">How Our Services Work</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-primary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary">1</span>
                    </div>
                    <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-primary bg-opacity-20"></div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Create Profile</h3>
                <p class="text-gray-300">Sign up and create your detailed business profile</p>
            </div>
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-primary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary">2</span>
                    </div>
                    <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-primary bg-opacity-20"></div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Define Needs</h3>
                <p class="text-gray-300">Specify your innovation needs or solutions</p>
            </div>
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-primary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary">3</span>
                    </div>
                    <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-primary bg-opacity-20"></div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Get Matched</h3>
                <p class="text-gray-300">Our AI finds your perfect business matches</p>
            </div>
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-primary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary">4</span>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Collaborate</h3>
                <p class="text-gray-300">Start your innovation journey together</p>
            </div>
        </div>
    </section>

    <!-- Additional Services -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Additional Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="bg-blue-600 bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Legal Support</h3>
                <p class="text-gray-300 text-sm">Expert legal assistance for partnership agreements and contracts</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="bg-green-600 bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Market Research</h3>
                <p class="text-gray-300 text-sm">Comprehensive market analysis and industry insights</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="bg-yellow-600 bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Mentorship</h3>
                <p class="text-gray-300 text-sm">Access to experienced industry mentors and advisors</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="bg-red-600 bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Innovation Labs</h3>
                <p class="text-gray-300 text-sm">Access to state-of-the-art facilities and resources</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of businesses already collaborating and growing through our platform.</p>
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
                        <li><a href="#" class="hover:text-primary transition">Home</a></li>
                        <li><a href="#" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="#" class="hover:text-primary transition">Services</a></li>
                        <li><a href="#" class="hover:text-primary transition">Success Stories</a></li>
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
