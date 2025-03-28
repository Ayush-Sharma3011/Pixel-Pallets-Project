<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biz-Fusion</title>
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
        </div>
    </nav>

    <!-- Login Section -->
    <section class="container mx-auto px-6 py-16 flex justify-center">
        <div class="bg-dark bg-opacity-50 p-8 rounded-xl shadow-2xl max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="font-['Playfair_Display'] text-3xl font-bold mb-2">Welcome Back</h1>
                <p class="text-gray-300">Sign in to your Biz-Fusion account</p>
            </div>
            
            <form action="javascript:void(0);" onsubmit="handleLogin(event)" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-700 rounded bg-gray-800">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-300">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-primary hover:underline">Forgot password?</a>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-primary hover:bg-opacity-90 text-white py-2 px-4 rounded-lg transition">Sign In</button>
                </div>
                
                <div class="text-center">
                    <p class="text-sm text-gray-400">Or sign in with</p>
                    <div class="flex justify-center space-x-4 mt-4">
                        <button type="button" class="bg-[#4267B2] p-2 rounded-full">
                            <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                                <path d="M9.19795 21.5H13.198V13.4901H16.8021L17.198 9.50977H13.198V7.5C13.198 6.94772 13.6457 6.5 14.198 6.5H17.198V2.5H14.198C11.4365 2.5 9.19795 4.73858 9.19795 7.5V9.50977H7.19795L6.80206 13.4901H9.19795V21.5Z"></path>
                            </svg>
                        </button>
                        <button type="button" class="bg-[#1DA1F2] p-2 rounded-full">
                            <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                            </svg>
                        </button>
                        <button type="button" class="bg-[#DB4437] p-2 rounded-full">
                            <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                                <path d="M12 11V8H7v4h5v3h-5v4h5v-3h5v-4h-5z M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <p class="text-gray-400">Don't have an account?</p>
                <div class="mt-4 flex space-x-4 justify-center">
                    <a href="startup-register.html" class="text-primary border border-primary px-4 py-2 rounded-lg hover:bg-primary hover:bg-opacity-10 transition">Register as Startup</a>
                    <a href="corporate-register.html" class="text-secondary border border-secondary px-4 py-2 rounded-lg hover:bg-secondary hover:bg-opacity-10 transition">Register as Corporate</a>
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
        function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // For demonstration purposes only
            if (email.includes('startup')) {
                window.location.href = 'startup-dashboard.html';
            } else if (email.includes('corporate')) {
                window.location.href = 'corporate-dashboard.html';
            } else {
                alert('Please use an email containing "startup" or "corporate" for this demo');
            }
        }
    </script>
</body>
</html> 