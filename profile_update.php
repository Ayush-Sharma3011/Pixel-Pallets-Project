<?php
session_start();
require_once 'config.php';
require_once 'points_system.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $user_type = $_SESSION['user_type'];
    
    // Get common profile fields
    $company_name = $_POST['company_name'] ?? '';
    $website = $_POST['website'] ?? '';
    $industry = $_POST['industry'] ?? '';
    $company_size = $_POST['company_size'] ?? '';
    $founded_year = $_POST['founded_year'] ?? '';
    $location = $_POST['location'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validate required fields
    $errors = [];
    
    if (empty($company_name)) {
        $errors[] = "Company name is required.";
    }
    
    if (empty($industry)) {
        $errors[] = "Industry is required.";
    }
    
    if (empty($description)) {
        $errors[] = "Company description is required.";
    }
    
    // Type-specific validation
    if ($user_type == 'startup') {
        $funding_stage = $_POST['funding_stage'] ?? '';
        $funding_amount = $_POST['funding_amount'] ?? '';
        $team_size = $_POST['team_size'] ?? '';
        $product_stage = $_POST['product_stage'] ?? '';
        $looking_for = $_POST['looking_for'] ?? [];
        
        if (empty($funding_stage)) {
            $errors[] = "Funding stage is required.";
        }
        
        if (empty($product_stage)) {
            $errors[] = "Product stage is required.";
        }
        
        if (empty($looking_for)) {
            $errors[] = "Please select what you're looking for.";
        }
    } else { // corporate
        $innovation_areas = $_POST['innovation_areas'] ?? [];
        $partnership_types = $_POST['partnership_types'] ?? [];
        $budget_range = $_POST['budget_range'] ?? '';
        
        if (empty($innovation_areas)) {
            $errors[] = "Innovation areas are required.";
        }
        
        if (empty($partnership_types)) {
            $errors[] = "Partnership types are required.";
        }
    }
    
    // If there are errors, redirect back to profile page
    if (!empty($errors)) {
        $_SESSION['profile_errors'] = $errors;
        
        if ($user_type == 'startup') {
            header("Location: startup-profile.php");
        } else {
            header("Location: corporate-profile.php");
        }
        exit();
    }
    
    // No errors, proceed with profile update
    // First, check if user already has a profile
    $stmt = $conn->prepare("SELECT id FROM user_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Prepare common profile data
    $profileData = [
        'company_name' => $company_name,
        'website' => $website,
        'industry' => $industry,
        'company_size' => $company_size,
        'founded_year' => $founded_year,
        'location' => $location,
        'description' => $description
    ];
    
    // Add type-specific data
    if ($user_type == 'startup') {
        $profileData['funding_stage'] = $funding_stage;
        $profileData['funding_amount'] = $funding_amount;
        $profileData['team_size'] = $team_size;
        $profileData['product_stage'] = $product_stage;
        $profileData['looking_for'] = implode(',', $looking_for);
    } else { // corporate
        $profileData['innovation_areas'] = implode(',', $innovation_areas);
        $profileData['partnership_types'] = implode(',', $partnership_types);
        $profileData['budget_range'] = $budget_range;
    }
    
    // Convert to JSON for storage
    $profileJson = json_encode($profileData);
    
    if ($result->num_rows > 0) {
        // Update existing profile
        $profile = $result->fetch_assoc();
        $stmt = $conn->prepare("UPDATE user_profiles SET profile_data = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $profileJson, $profile['id']);
    } else {
        // Create new profile
        $stmt = $conn->prepare("INSERT INTO user_profiles (user_id, profile_data, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $stmt->bind_param("is", $user_id, $profileJson);
    }
    
    if ($stmt->execute()) {
        // Check if this is the first time completing the profile
        $checkStmt = $conn->prepare("SELECT profile_completed FROM users WHERE id = ?");
        $checkStmt->bind_param("i", $user_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $user = $checkResult->fetch_assoc();
        
        // If profile wasn't completed before, award points
        if (!$user['profile_completed']) {
            // Update user's profile completion status
            $updateStmt = $conn->prepare("UPDATE users SET profile_completed = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $user_id);
            $updateStmt->execute();
            
            // Award points for profile completion
            $pointsSystem = new PointsSystem($conn);
            $pointsSystem->awardProfileCompletionPoints($user_id);
            
            // Update session
            $_SESSION['total_points'] += POINTS_COMPLETE_PROFILE;
            $_SESSION['points_message'] = "Congratulations! You earned " . POINTS_COMPLETE_PROFILE . " points for completing your profile!";
        }
        
        $_SESSION['profile_success'] = "Your profile has been updated successfully.";
        
        // Redirect to dashboard
        if ($user_type == 'startup') {
            header("Location: startup-dashboard.html");
        } else {
            header("Location: corporate-dashboard.html");
        }
        exit();
    } else {
        $_SESSION['profile_errors'] = ["Failed to update profile. Please try again."];
        
        if ($user_type == 'startup') {
            header("Location: startup-profile.php");
        } else {
            header("Location: corporate-profile.php");
        }
        exit();
    }
} else {
    // Not a POST request, redirect to profile page
    if ($_SESSION['user_type'] == 'startup') {
        header("Location: startup-profile.php");
    } else {
        header("Location: corporate-profile.php");
    }
    exit();
}
?> 