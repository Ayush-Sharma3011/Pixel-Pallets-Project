<?php
/**
 * Points System Configuration
 * 
 * This file defines the point values for various activities in the Biz-Fusion platform.
 */

// Registration Points
define('POINTS_REGISTER_STARTUP', 100);
define('POINTS_REGISTER_CORPORATE', 150);

// Login Points
define('POINTS_LOGIN', 10);  // Daily login bonus

// Profile Completion Points
define('POINTS_COMPLETE_PROFILE', 50);  // Complete profile details
define('POINTS_UPLOAD_LOGO', 20);       // Upload company logo
define('POINTS_ADD_TEAM_MEMBER', 15);   // Add team member

// Activity Points
define('POINTS_POST_INNOVATION_NEED', 30);    // Corporate posts an innovation need
define('POINTS_SUBMIT_SOLUTION', 25);         // Startup submits a solution
define('POINTS_CONNECT_MATCH', 40);           // Connect with a potential match
define('POINTS_SUCCESSFUL_PARTNERSHIP', 100); // Form a successful partnership

// Engagement Points
define('POINTS_SEND_MESSAGE', 5);      // Send a message
define('POINTS_ATTEND_EVENT', 20);     // Attend a virtual or physical event
define('POINTS_SHARE_RESOURCE', 15);   // Share a resource or article

// Achievement Bonuses
define('POINTS_FIRST_PARTNERSHIP', 200);   // First successful partnership
define('POINTS_FIVE_SOLUTIONS', 150);      // Submit 5 solutions (startups)
define('POINTS_FIVE_NEEDS', 150);          // Post 5 innovation needs (corporates)

/**
 * Points threshold levels 
 * - Each level has a minimum point requirement
 * - Higher levels unlock more features
 */
$POINTS_LEVELS = [
    1 => 0,       // Bronze - Default
    2 => 300,     // Silver
    3 => 1000,    // Gold
    4 => 2500,    // Platinum
    5 => 5000     // Diamond
];

/**
 * Level Benefits - Features unlocked at each level
 */
$LEVEL_BENEFITS = [
    1 => [
        'Basic Matching',
        'Limited Messaging (5 per day)',
        'Basic Dashboard'
    ],
    2 => [
        'Enhanced Matching Algorithm',
        'Increased Messaging (15 per day)',
        'View Basic Analytics'
    ],
    3 => [
        'Advanced Matching Preferences',
        'Unlimited Messaging',
        'Featured Profile (2 days/month)'
    ],
    4 => [
        'Priority Matching',
        'Detailed Analytics',
        'Featured Profile (1 week/month)',
        'Early Access to New Features'
    ],
    5 => [
        'Elite Matching',
        'Dedicated Account Manager',
        'Featured Profile (Permanent)',
        'Monthly Strategy Session',
        'Custom Partnership Reports'
    ]
];
?> 