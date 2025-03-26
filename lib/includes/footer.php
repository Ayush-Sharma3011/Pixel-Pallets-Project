<?php
/**
 * Footer Template
 * 
 * This file contains the standard footer used across all pages
 */
?>
    <!-- Footer -->
    <footer class="bg-dark bg-opacity-80 py-12 mt-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="/public/images/bizfusion_refined.png" alt="Biz-Fusion Logo" class="h-8 mb-4">
                    <p class="text-gray-400">Connecting innovative startups with established corporations for mutual growth and success.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/index.php" class="hover:text-primary transition">Home</a></li>
                        <li><a href="/about.php" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="/services.php" class="hover:text-primary transition">Services</a></li>
                        <li><a href="/success-stories.php" class="hover:text-primary transition">Success Stories</a></li>
                        <li><a href="/contact.php" class="hover:text-primary transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/blog.php" class="hover:text-primary transition">Blog</a></li>
                        <li><a href="/guides.php" class="hover:text-primary transition">Guides</a></li>
                        <li><a href="/events.php" class="hover:text-primary transition">Events</a></li>
                        <li><a href="/faq.php" class="hover:text-primary transition">FAQ</a></li>
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
    
    <!-- Scripts -->
    <script src="/public/js/main.js"></script>
</body>
</html> 