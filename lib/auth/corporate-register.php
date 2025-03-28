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
                <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold mb-6">Corporate <span class="text-secondary">Registration</span></h1>
                <p class="text-gray-300 text-lg">Join our platform to discover innovative startups, accelerate your innovation strategy, and stay ahead of the competition.</p>
            </div>

            <div class="bg-dark bg-opacity-50 rounded-xl p-8 md:p-12">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-full max-w-md">
                        <div class="flex justify-between">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center mx-auto">1</div>
                                <p class="text-sm mt-2">Account</p>
                            </div>
                            <div class="flex-1 flex items-center justify-center">
                                <div class="h-1 w-full bg-secondary bg-opacity-30"></div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-secondary bg-opacity-30 text-white rounded-full flex items-center justify-center mx-auto">2</div>
                                <p class="text-sm mt-2">Company</p>
                            </div>
                            <div class="flex-1 flex items-center justify-center">
                                <div class="h-1 w-full bg-secondary bg-opacity-30"></div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-secondary bg-opacity-30 text-white rounded-full flex items-center justify-center mx-auto">3</div>
                                <p class="text-sm mt-2">Innovation Needs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form>
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
                        <label for="job_title" class="block text-sm font-medium text-gray-300 mb-2">Job Title*</label>
                        <input type="text" id="job_title" name="job_title" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    
                    <div class="mb-6">
                        <label for="work_email" class="block text-sm font-medium text-gray-300 mb-2">Work Email Address*</label>
                        <input type="email" id="work_email" name="work_email" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                        <p class="text-xs text-gray-400 mt-1">Please use your corporate email address for verification purposes</p>
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
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number*</label>
                        <input type="tel" id="phone" name="phone" required class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    
                    <div class="mb-8">
                        <label class="flex items-center">
                            <input type="checkbox" required class="rounded text-secondary focus:ring-secondary">
                            <span class="ml-2 text-sm text-gray-300">I agree to the <a href="#" class="text-secondary hover:underline">Terms of Service</a> and <a href="#" class="text-secondary hover:underline">Privacy Policy</a>*</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <a href="index.html" class="text-gray-400 hover:text-white transition">Cancel</a>
                        <button type="submit" class="bg-secondary hover:bg-opacity-90 text-white font-medium py-3 px-8 rounded-lg transition">Continue to Company Info</button>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-400">Already have an account? <a href="login.html" class="text-secondary hover:underline">Sign in</a></p>
                <p class="text-gray-400 mt-2">Are you a startup? <a href="startup-register.html" class="text-secondary hover:underline">Register as a Startup</a></p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Benefits for Corporates</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <div class="bg-secondary bg-opacity-20 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Innovation Acceleration</h3>
                <p class="text-gray-300">Access cutting-edge technologies and solutions from vetted startups to accelerate your innovation strategy.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <div class="bg-secondary bg-opacity-20 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Market Intelligence</h3>
                <p class="text-gray-300">Stay ahead of industry trends by connecting with startups at the forefront of technological advancement.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <div class="bg-secondary bg-opacity-20 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Cost-Effective R&D</h3>
                <p class="text-gray-300">Reduce research and development costs by partnering with startups that have already developed innovative solutions.</p>
            </div>
        </div>
    </section>

    <!-- Testimonial -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-dark bg-opacity-50 rounded-xl p-8 md:p-12">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3 mb-8 md:mb-0 flex justify-center">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="James Wilson" class="w-32 h-32 rounded-full border-4 border-secondary">
                </div>
                <div class="md:w-2/3 md:pl-12">
                    <svg class="h-12 w-12 text-secondary opacity-30 mb-4" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                    </svg>
                    <p class="text-xl text-gray-300 mb-6">Biz-Fusion has revolutionized our approach to open innovation. We've found three game-changing startups through the platform that have helped us launch new products months ahead of schedule.</p>
                    <div>
                        <h4 class="font-semibold">James Wilson</h4>
                        <p class="text-gray-400">Chief Innovation Officer, Global Enterprises</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">How It Works for Corporates</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-secondary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-secondary">1</span>
                    </div>
                    <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-secondary bg-opacity-20"></div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Create Profile</h3>
                <p class="text-gray-300">Set up your corporate profile with your innovation focus areas</p>
            </div>
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-secondary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-secondary">2</span>
                    </div>
                    <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-secondary bg-opacity-20"></div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Post Innovation Needs</h3>
                <p class="text-gray-300">Specify your innovation challenges and technology requirements</p>
            </div>
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-secondary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-secondary">3</span>
                    </div>
                    <div class="hidden md:block absolute top-10 left-full w-full h-0.5 bg-secondary bg-opacity-20"></div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Review Matches</h3>
                <p class="text-gray-300">Evaluate AI-matched startups that meet your specific criteria</p>
            </div>
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-secondary bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-secondary">4</span>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-4">Collaborate</h3>
                <p class="text-gray-300">Connect with selected startups and begin your innovation journey</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-12">Frequently Asked Questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">How is corporate verification handled?</h3>
                <p class="text-gray-300">We verify all corporate accounts through your business email domain and may request additional documentation for larger enterprises to ensure platform security.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">Can multiple team members access our account?</h3>
                <p class="text-gray-300">Yes, our corporate plans allow for multiple team members with different permission levels to collaborate on the platform.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">How are startups vetted on the platform?</h3>
                <p class="text-gray-300">All startups undergo a thorough verification process, including business registration checks, product validation, and team background verification.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">What subscription plans are available?</h3>
                <p class="text-gray-300">We offer tiered plans based on company size and needs, from Basic to Enterprise. All plans include our core matching algorithm with varying levels of additional services.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Ready to Transform Your Innovation Strategy?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join hundreds of forward-thinking corporations already discovering breakthrough innovations on our platform.</p>
            <button type="button" class="bg-white text-secondary hover:bg-opacity-90 px-8 py-3 rounded-full transition font-medium">Complete Your Registration</button>
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