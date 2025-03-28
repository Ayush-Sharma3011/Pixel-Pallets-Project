<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Dashboard - Biz-Fusion</title>
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
                <a href="corporate-dashboard.html" class="text-secondary transition">Dashboard</a>
                <a href="innovation-needs.html" class="hover:text-secondary transition">Innovation Needs</a>
                <a href="startup-discovery.html" class="hover:text-secondary transition">Startup Discovery</a>
                <a href="messages.html" class="hover:text-secondary transition">Messages</a>
                <a href="profile.html" class="hover:text-secondary transition">Profile</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-white hover:text-secondary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center">
                        <span class="font-semibold text-sm">GC</span>
                    </div>
                    <span>Global Corp</span>
                </div>
                <a href="index.html" class="text-sm text-gray-400 hover:text-white">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="font-['Playfair_Display'] text-3xl font-bold mb-2">Corporate Dashboard</h1>
                <p class="text-gray-300">Welcome back, Global Corp! Here's your innovation overview.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <button class="bg-secondary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Post Innovation Need</button>
                <button class="border border-secondary text-secondary hover:bg-secondary hover:bg-opacity-10 px-6 py-2 rounded-full transition">View Analytics</button>
            </div>
        </div>
    </section>

    <!-- Dashboard Stats -->
    <section class="container mx-auto px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Active Innovation Needs</h3>
                </div>
                <p class="text-3xl font-bold">3</p>
                <p class="text-sm text-gray-400 mt-2">Open challenges seeking solutions</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Startup Matches</h3>
                    <span class="bg-secondary bg-opacity-20 text-secondary px-2 py-1 rounded text-sm">+8 this week</span>
                </div>
                <p class="text-3xl font-bold">24</p>
                <p class="text-sm text-gray-400 mt-2">Potential innovation partners</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Active Discussions</h3>
                </div>
                <p class="text-3xl font-bold">7</p>
                <p class="text-sm text-gray-400 mt-2">Ongoing conversations</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold">Partnerships Formed</h3>
                </div>
                <p class="text-3xl font-bold">5</p>
                <p class="text-sm text-gray-400 mt-2">Successful collaborations to date</p>
            </div>
        </div>
    </section>

    <!-- Innovation Needs -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-['Playfair_Display'] font-bold">Your Innovation Needs</h2>
            <button class="text-secondary hover:underline text-sm">View All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="h-2 bg-green-500"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-semibold">AI Customer Service Solutions</h3>
                        <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">Active</span>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Looking for innovative AI solutions to enhance our customer service experience and reduce response times.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-500 bg-opacity-20 text-blue-400 px-2 py-1 rounded text-xs">AI</span>
                        <span class="bg-purple-500 bg-opacity-20 text-purple-400 px-2 py-1 rounded text-xs">Customer Service</span>
                        <span class="bg-pink-500 bg-opacity-20 text-pink-400 px-2 py-1 rounded text-xs">NLP</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">12 matches</span>
                        <button class="text-secondary hover:underline text-sm">View Matches</button>
                    </div>
                </div>
            </div>
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="h-2 bg-green-500"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-semibold">Blockchain Payment Solutions</h3>
                        <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">Active</span>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Seeking innovative blockchain solutions to streamline international payments and reduce transaction costs.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-red-500 bg-opacity-20 text-red-400 px-2 py-1 rounded text-xs">Blockchain</span>
                        <span class="bg-orange-500 bg-opacity-20 text-orange-400 px-2 py-1 rounded text-xs">Payments</span>
                        <span class="bg-yellow-500 bg-opacity-20 text-yellow-400 px-2 py-1 rounded text-xs">FinTech</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">8 matches</span>
                        <button class="text-secondary hover:underline text-sm">View Matches</button>
                    </div>
                </div>
            </div>
            <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
                <div class="h-2 bg-green-500"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-semibold">Sustainable Supply Chain</h3>
                        <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">Active</span>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Looking for innovative solutions to make our supply chain more sustainable and reduce carbon footprint.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">Sustainability</span>
                        <span class="bg-teal-500 bg-opacity-20 text-teal-400 px-2 py-1 rounded text-xs">Supply Chain</span>
                        <span class="bg-blue-500 bg-opacity-20 text-blue-400 px-2 py-1 rounded text-xs">Green Tech</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">4 matches</span>
                        <button class="text-secondary hover:underline text-sm">View Matches</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Startup Matches -->
    <section class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-['Playfair_Display'] font-bold">Top Startup Matches</h2>
            <button class="text-secondary hover:underline text-sm">View All Matches</button>
        </div>
        <div class="overflow-hidden bg-dark bg-opacity-50 rounded-xl">
            <table class="min-w-full divide-y divide-gray-800">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Startup</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Innovation Area</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Match Score</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="font-semibold text-sm">TS</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">TechStart</div>
                                    <div class="text-xs text-gray-400">AI Solutions</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-blue-500 bg-opacity-20 text-blue-400 px-2 py-1 rounded text-xs">AI Customer Service</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-secondary font-semibold">92%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-yellow-500 bg-opacity-20 text-yellow-400 px-2 py-1 rounded text-xs">In Discussion</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <button class="text-secondary hover:underline">View Profile</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="font-semibold text-sm">BC</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">BlockChain Pay</div>
                                    <div class="text-xs text-gray-400">Payment Solutions</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-red-500 bg-opacity-20 text-red-400 px-2 py-1 rounded text-xs">Blockchain Payments</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-secondary font-semibold">89%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">New Match</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <button class="text-secondary hover:underline">View Profile</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="font-semibold text-sm">GS</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">GreenSupply</div>
                                    <div class="text-xs text-gray-400">Sustainable Solutions</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-500 bg-opacity-20 text-green-400 px-2 py-1 rounded text-xs">Sustainable Supply Chain</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-secondary font-semibold">85%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-purple-500 bg-opacity-20 text-purple-400 px-2 py-1 rounded text-xs">Meeting Scheduled</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <button class="text-secondary hover:underline">View Profile</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-['Playfair_Display'] font-bold mb-6">Recent Activity</h2>
        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
            <div class="space-y-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="font-semibold text-sm">TS</span>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium">TechStart sent you a message</p>
                            <span class="text-xs text-gray-400">2 hours ago</span>
                        </div>
                        <p class="text-sm text-gray-300 mt-1">We've reviewed your requirements and would like to schedule a demo of our AI solution...</p>
                        <button class="text-secondary hover:underline text-xs mt-2">View Message</button>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-6 flex">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium">You posted a new innovation need</p>
                            <span class="text-xs text-gray-400">Yesterday</span>
                        </div>
                        <p class="text-sm text-gray-300 mt-1">Sustainable Supply Chain - Looking for innovative solutions to make our supply chain more sustainable...</p>
                        <button class="text-secondary hover:underline text-xs mt-2">View Innovation Need</button>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-6 flex">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                            <span class="font-semibold text-sm">GS</span>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium">You scheduled a meeting with GreenSupply</p>
                            <span class="text-xs text-gray-400">2 days ago</span>
                        </div>
                        <p class="text-sm text-gray-300 mt-1">Virtual meeting scheduled for May 18, 2023 at 2:00 PM EST</p>
                        <button class="text-secondary hover:underline text-xs mt-2">View Calendar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-8 mt-16">
        <div class="container mx-auto px-6">
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; 2023 Biz-Fusion. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Dashboard functionality would go here
    </script>
</body>
</html> 