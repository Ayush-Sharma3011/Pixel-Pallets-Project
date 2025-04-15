<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/models/Contact.php';
require_once __DIR__ . '/includes/Session.php';

$session = new Session();
$contact = new Contact();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $contact->name = $_POST['name'] ?? '';
    $contact->email = $_POST['email'] ?? '';
    $contact->subject = $_POST['subject'] ?? '';
    $contact->message = $_POST['message'] ?? '';
    
    // Validate data
    $errors = [];
    if (empty($contact->name)) {
        $errors[] = "Name is required";
    }
    if (empty($contact->email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($contact->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($contact->subject)) {
        $errors[] = "Subject is required";
    }
    if (empty($contact->message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, save to database
    if (empty($errors)) {
        if ($contact->create()) {
            $session->setFlash('Your message has been sent successfully!', 'success');
            header("Location: " . SITE_URL . "/contact.html");
            exit();
        } else {
            $session->setFlash('Failed to send message. Please try again.', 'error');
            header("Location: " . SITE_URL . "/contact.html");
            exit();
        }
    } else {
        $session->setFlash(implode("<br>", $errors), 'error');
        header("Location: " . SITE_URL . "/contact.html");
        exit();
    }
} else {
    // Not a POST request
    header("Location: " . SITE_URL . "/contact.html");
    exit();
}
?> 