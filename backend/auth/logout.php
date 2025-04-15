<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Session.php';

$session = new Session();
$session->destroy();

header("Location: " . SITE_URL . "/backend/auth/login.php");
exit();
?> 