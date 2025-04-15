<?php
// Website Configuration
define('SITE_NAME', 'BizFusion');
define('SITE_URL', 'http://localhost/bizfusion');
define('ADMIN_EMAIL', 'admin@bizfusion.com');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bizfusion');
define('DB_USER', 'root');
define('DB_PASS', '');

// Session Configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'bizfusion_session');

// File Upload Configuration
define('UPLOAD_DIR', '../uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('UTC');
?> 