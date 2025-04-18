<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Stories - Biz-Fusion</title>
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
                <a href="services.php" class="hover:text-primary transition">Services</a>
                <a href="success-stories.php" class="text-primary transition">Success Stories</a>
                <a href="contact.php" class="hover:text-primary transition">Contact</a>
            </div>
            <div>
                <a href="login.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Success <span class="text-primary">Stories</span></h1>
            <p class="text-gray-300 text-lg mb-8">Discover how innovative startups and forward-thinking corporations have achieved remarkable growth through partnerships formed on our platform.</p>
        </div>
    </section>

    <!-- Featured Success Story -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-dark bg-opacity-50 rounded-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-12 flex flex-col justify-center">
                    <div class="flex items-center mb-6">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-['Playfair_Display'] font-bold">TechNova & Global Innovations</h3>
                    </div>
                    <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Revolutionizing Sustainable Energy Solutions</h2>
                    <p class="text-gray-300 mb-6">When TechNova, a promising startup with groundbreaking battery technology, connected with Global Innovations through Biz-Fusion, they unlocked unprecedented opportunities. Their partnership led to a $12M investment, accelerating product development and market entry by 18 months.</p>
                    <div class="flex flex-wrap gap-4 mb-8">
                        <span class="bg-primary bg-opacity-20 text-primary px-4 py-2 rounded-full text-sm">Clean Energy</span>
                        <span class="bg-secondary bg-opacity-20 text-secondary px-4 py-2 rounded-full text-sm">Technology Transfer</span>
                        <span class="bg-purple-600 bg-opacity-20 text-purple-600 px-4 py-2 rounded-full text-sm">Strategic Investment</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex -space-x-4">
                            <img class="w-12 h-12 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sarah Chen, CEO of TechNova">
                            <img class="w-12 h-12 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Rodriguez, Innovation Director at Global Innovations">
                        </div>
                        <a href="#" class="ml-6 text-primary hover:underline">Read Full Case Study →</a>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-primary to-secondary h-64 lg:h-auto flex items-center justify-center p-8">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="TechNova & Global Innovations Partnership" class="rounded-xl shadow-2xl max-h-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories Grid -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-16">More Success Stories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Story 1 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="MediTech & HealthCorp Partnership" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-blue-600 bg-opacity-20 text-blue-600 px-3 py-1 rounded-full text-xs">Healthcare</span>
                        <span class="text-gray-400 text-sm">6 months ago</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">MediTech & HealthCorp</h3>
                    <p class="text-gray-300 text-sm mb-4">AI-powered diagnostic tools developed by MediTech found the perfect partner in HealthCorp, leading to implementation across 200+ hospitals.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/22.jpg" alt="Emma Johnson">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/54.jpg" alt="David Kim">
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:underline text-sm">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Story 2 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="FinEdge & BankCorp Partnership" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-green-600 bg-opacity-20 text-green-600 px-3 py-1 rounded-full text-xs">Fintech</span>
                        <span class="text-gray-400 text-sm">1 year ago</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">FinEdge & BankCorp</h3>
                    <p class="text-gray-300 text-sm mb-4">FinEdge's blockchain payment solution integrated with BankCorp's infrastructure, reaching 2M+ customers in just 9 months.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/32.jpg" alt="James Wilson">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/28.jpg" alt="Sophia Lee">
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:underline text-sm">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Story 3 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1605792657660-596af9009e82?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="EcoSmart & IndustryCo Partnership" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-yellow-600 bg-opacity-20 text-yellow-600 px-3 py-1 rounded-full text-xs">Sustainability</span>
                        <span class="text-gray-400 text-sm">8 months ago</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">EcoSmart & IndustryCo</h3>
                    <p class="text-gray-300 text-sm mb-4">EcoSmart's waste reduction technology helped IndustryCo reduce environmental impact by 40% while cutting operational costs by 15%.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Olivia Martinez">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/41.jpg" alt="Robert Chen">
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:underline text-sm">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Story 4 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="EduTech & LearnCorp Partnership" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-purple-600 bg-opacity-20 text-purple-600 px-3 py-1 rounded-full text-xs">Education</span>
                        <span class="text-gray-400 text-sm">3 months ago</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">EduTech & LearnCorp</h3>
                    <p class="text-gray-300 text-sm mb-4">EduTech's personalized learning platform scaled rapidly after partnering with LearnCorp, now serving 500,000+ students globally.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/86.jpg" alt="Daniel Park">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/42.jpg" alt="Jessica Taylor">
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:underline text-sm">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Story 5 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="AgriTech & FoodCorp Partnership" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-red-600 bg-opacity-20 text-red-600 px-3 py-1 rounded-full text-xs">Agriculture</span>
                        <span class="text-gray-400 text-sm">5 months ago</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">AgriTech & FoodCorp</h3>
                    <p class="text-gray-300 text-sm mb-4">AgriTech's precision farming solution partnered with FoodCorp to increase crop yields by 35% while reducing water usage by 40%.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/54.jpg" alt="Maria Rodriguez">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/67.jpg" alt="Thomas Johnson">
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:underline text-sm">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Story 6 -->
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="SecureTech & DataCorp Partnership" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="bg-indigo-600 bg-opacity-20 text-indigo-600 px-3 py-1 rounded-full text-xs">Cybersecurity</span>
                        <span class="text-gray-400 text-sm">2 months ago</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">SecureTech & DataCorp</h3>
                    <p class="text-gray-300 text-sm mb-4">SecureTech's AI-driven threat detection system found enterprise-scale implementation through DataCorp, securing 10M+ user accounts.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/men/22.jpg" alt="Alex Wong">
                                <img class="w-8 h-8 rounded-full border-2 border-dark" src="https://randomuser.me/api/portraits/women/35.jpg" alt="Rachel Green">
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:underline text-sm">Read More →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-16">What Our Partners Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl relative">
                <div class="absolute -top-5 -left-5 text-6xl text-primary opacity-30">"</div>
                <p class="text-gray-300 mb-6 relative z-10">Biz-Fusion completely transformed our approach to corporate innovation. The quality of startups we've connected with has been exceptional, and the platform's matching algorithm saved us countless hours of searching.</p>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/23.jpg" alt="Jennifer Williams" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Jennifer Williams</h4>
                        <p class="text-gray-400 text-sm">Chief Innovation Officer, Global Enterprises</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl relative">
                <div class="absolute -top-5 -left-5 text-6xl text-secondary opacity-30">"</div>
                <p class="text-gray-300 mb-6 relative z-10">As a startup founder, getting in front of the right corporate partners was always our biggest challenge. Biz-Fusion not only connected us with perfect matches but helped us prepare for those crucial first meetings.</p>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/men/78.jpg" alt="Marcus Chen" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Marcus Chen</h4>
                        <p class="text-gray-400 text-sm">Founder & CEO, TechInnovate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-6">Ready to Write Your Success Story?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join thousands of businesses already collaborating and growing through our platform.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="dashboard/startup.php" class="bg-white text-primary hover:bg-opacity-90 px-8 py-3 rounded-full transition font-medium">Register as Startup</a>
                <a href="dashboard/corporate.php" class="border border-white hover:bg-white hover:bg-opacity-10 px-8 py-3 rounded-full transition font-medium">Register as Corporate</a>
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