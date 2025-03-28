<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Biz-Fusion</title>
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
                <a href="contact.html" class="text-primary transition">Contact</a>
            </div>
            <div>
                <a href="login.html" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Get in <span class="text-primary">Touch</span></h1>
            <p class="text-gray-300 text-lg mb-8">Have questions about our platform or services? We're here to help you connect, collaborate, and grow your business.</p>
        </div>
    </section>

    <!-- Contact Information and Form -->
    <section class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-8">Contact Information</h2>
                
                <div class="space-y-8">
                    <!-- Office Location -->
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Our Office</h3>
                            <p class="text-gray-300">123 Innovation Street</p>
                            <p class="text-gray-300">San Francisco, CA 94103</p>
                            <p class="text-gray-300">United States</p>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex items-start">
                        <div class="bg-secondary bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Phone</h3>
                            <p class="text-gray-300">General: +1 (555) 123-4567</p>
                            <p class="text-gray-300">Support: +1 (555) 987-6543</p>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex items-start">
                        <div class="bg-purple-600 bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Email</h3>
                            <p class="text-gray-300">General: info@bizfusion.com</p>
                            <p class="text-gray-300">Support: support@bizfusion.com</p>
                            <p class="text-gray-300">Partnerships: partners@bizfusion.com</p>
                        </div>
                    </div>
                    
                    <!-- Hours -->
                    <div class="flex items-start">
                        <div class="bg-blue-600 bg-opacity-20 p-3 rounded-xl mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Business Hours</h3>
                            <p class="text-gray-300">Monday - Friday: 9:00 AM - 6:00 PM PST</p>
                            <p class="text-gray-300">Saturday - Sunday: Closed</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-12">
                    <h3 class="text-xl font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-dark bg-opacity-50 hover:bg-primary hover:bg-opacity-20 p-3 rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-dark bg-opacity-50 hover:bg-primary hover:bg-opacity-20 p-3 rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-dark bg-opacity-50 hover:bg-primary hover:bg-opacity-20 p-3 rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-dark bg-opacity-50 hover:bg-primary hover:bg-opacity-20 p-3 rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <h2 class="text-3xl font-['Playfair_Display'] font-bold mb-8">Send Us a Message</h2>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    
                    <div class="mb-6">
                        <label for="company" class="block text-sm font-medium text-gray-300 mb-2">Company Name</label>
                        <input type="text" id="company" name="company" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    
                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                        <input type="text" id="subject" name="subject" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full bg-dark bg-opacity-50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-300">I agree to the <a href="#" class="text-primary hover:underline">Privacy Policy</a> and <a href="#" class="text-primary hover:underline">Terms of Service</a>.</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary hover:bg-opacity-90 text-white font-medium py-3 px-6 rounded-lg transition">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="bg-dark bg-opacity-50 rounded-xl overflow-hidden">
            <h2 class="text-3xl font-['Playfair_Display'] font-bold p-8">Visit Our Office</h2>
            <div class="h-96 w-full">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0968173775!2d-122.41941492392031!3d37.77492997197543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sTwitter%20HQ!5e0!3m2!1sen!2sus!4v1691204456430!5m2!1sen!2sus" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-['Playfair_Display'] font-bold text-center mb-16">Frequently Asked Questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">How quickly can I expect a response?</h3>
                <p class="text-gray-300">We aim to respond to all inquiries within 24 business hours. For urgent matters, please call our support line directly.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">Do you offer virtual meetings?</h3>
                <p class="text-gray-300">Yes, we offer virtual consultations via Zoom, Microsoft Teams, or Google Meet. Please indicate your preference when scheduling.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">Can I schedule a demo of the platform?</h3>
                <p class="text-gray-300">Absolutely! You can request a personalized demo through our contact form or by emailing demo@bizfusion.com.</p>
            </div>
            <div class="bg-dark bg-opacity-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold mb-4">How do I report technical issues?</h3>
                <p class="text-gray-300">Technical issues can be reported to our support team at support@bizfusion.com or through the help center in your account dashboard.</p>
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