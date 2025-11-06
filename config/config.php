<?php

// Database ki settings - yahan apne local setup ke hisaab se change karo
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'traveltales');
define('DB_USER', 'root');
define('DB_PASS', '00001111');

// Application ki basic settings
define('APP_NAME', 'TravelTales');
define('APP_URL', 'http://localhost/traveltales');

// File upload ka folder
define('UPLOAD_PATH', 'uploads/');

// Pagination ke liye limits
define('POSTS_PER_PAGE', 12);
define('BLOGS_PER_PAGE', 9);

// Indian timezone set karte hain
date_default_timezone_set('Asia/Kolkata');

// Development ke liye errors show karte hain - production mein band kar dena
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>