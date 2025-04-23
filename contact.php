<?php
// Include database connection
require_once 'backend/config/database.php';

// Initialize variables
$name = $email = $subject = $message = "";
$name_err = $email_err = $subject_err = $message_err = "";
$success_message = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_err = "Please enter a subject.";
    } else {
        $subject = trim($_POST["subject"]);
    }
    
    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter your message.";
    } else {
        $message = trim($_POST["message"]);
    }
    
    // Check input errors before inserting in database
    if (empty($name_err) && empty($email_err) && empty($subject_err) && empty($message_err)) {
        
        // Create database connection
        $database = new Database();
        $conn = $database->getConnection();
        
        // Prepare an insert statement
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":subject", $param_subject, PDO::PARAM_STR);
            $stmt->bindParam(":message", $param_message, PDO::PARAM_STR);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_subject = $subject;
            $param_message = $message;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                /* 
                // Email functionality - Disabled due to local mail server configuration
                // To enable email functionality in a production environment:
                // 1. Configure an SMTP server or use a library like PHPMailer
                // 2. For PHPMailer, install using: composer require phpmailer/phpmailer
                // 3. Then implement the code below:
                
                // require 'vendor/autoload.php';
                // use PHPMailer\PHPMailer\PHPMailer;
                // use PHPMailer\PHPMailer\Exception;
                
                // $mail = new PHPMailer(true);
                // try {
                //     $mail->isSMTP();
                //     $mail->Host = 'smtp.gmail.com';  // Your SMTP server
                //     $mail->SMTPAuth = true;
                //     $mail->Username = 'your-email@gmail.com';  // SMTP username
                //     $mail->Password = 'your-password';  // SMTP password
                //     $mail->SMTPSecure = 'tls';
                //     $mail->Port = 587;
                
                //     $mail->setFrom($email, $name);
                //     $mail->addAddress('sharmaayush300424@gmail.com');
                //     $mail->Subject = "Biz-Fusion Contact Form: " . $subject;
                //     $mail->Body = "You have received a new message from the Biz-Fusion contact form.\n\n".
                //                   "Name: ".$name."\n".
                //                   "Email: ".$email."\n".
                //                   "Subject: ".$subject."\n".
                //                   "Message: ".$message."\n";
                
                //     $mail->send();
                // } catch (Exception $e) {
                //     // Log error but don't show to user
                //     error_log('Message could not be sent. Mailer Error: '. $mail->ErrorInfo);
                // }
                */
                
                // Message sent successfully
                $success_message = "Your message has been sent. Thank you for contacting us!";
                $name = $email = $subject = $message = "";
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            unset($stmt);
        }
        
        // Close connection
        unset($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Biz-Fusion</title>
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
                <a href="success-stories.php" class="hover:text-primary transition">Success Stories</a>
                <a href="contact.php" class="text-primary transition">Contact</a>
            </div>
            <div>
                <a href="login.php" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-full transition">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-12 md:py-20">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold mb-6">Get In Touch</h1>
            <p class="text-gray-300 text-lg mb-8">Have questions about Biz-Fusion? Want to partner with us? We'd love to hear from you.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <h2 class="text-2xl font-semibold mb-6">Contact Information</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Address</h3>
                            <p class="text-gray-400">123 Innovation Street, San Francisco, CA 94103</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Email</h3>
                            <p class="text-gray-400">info@bizfusion.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Phone</h3>
                            <p class="text-gray-400">+1 (555) 123-4567</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10">
                    <h3 class="font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="bg-dark bg-opacity-50 p-8 rounded-xl">
                <h2 class="text-2xl font-semibold mb-6">Send Us a Message</h2>
                
                <?php if(!empty($success_message)): ?>
                <div class="bg-green-500 bg-opacity-20 text-green-100 p-4 rounded-lg mb-6">
                    <?php echo $success_message; ?>
                </div>
                <?php endif; ?>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Your Name</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 bg-dark bg-opacity-70 border border-gray-700 rounded-lg focus:outline-none focus:border-primary <?php echo (!empty($name_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $name; ?>">
                        <span class="text-red-400 text-xs mt-1"><?php echo $name_err; ?></span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Your Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2 bg-dark bg-opacity-70 border border-gray-700 rounded-lg focus:outline-none focus:border-primary <?php echo (!empty($email_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="text-red-400 text-xs mt-1"><?php echo $email_err; ?></span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="subject" class="block text-sm font-medium text-gray-300 mb-1">Subject</label>
                        <input type="text" name="subject" id="subject" class="w-full px-4 py-2 bg-dark bg-opacity-70 border border-gray-700 rounded-lg focus:outline-none focus:border-primary <?php echo (!empty($subject_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $subject; ?>">
                        <span class="text-red-400 text-xs mt-1"><?php echo $subject_err; ?></span>
                    </div>
                    
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-1">Message</label>
                        <textarea name="message" id="message" rows="6" class="w-full px-4 py-2 bg-dark bg-opacity-70 border border-gray-700 rounded-lg focus:outline-none focus:border-primary <?php echo (!empty($message_err)) ? 'border-red-500' : ''; ?>"><?php echo $message; ?></textarea>
                        <span class="text-red-400 text-xs mt-1"><?php echo $message_err; ?></span>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary hover:bg-opacity-90 text-white font-medium py-2 px-4 rounded-full transition">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="bg-dark bg-opacity-50 p-4 rounded-xl">
        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d27273.7219521439!2d75.6370873!3d31.2977955!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1745218731338!5m2!1sen!2sin" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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